<?php

namespace App\Livewire\Admin\TeamMembers;

use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Team Members'])]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed = false;

    public ?int $editingId = null;
    public ?int $deletingId = null;

    public string $name = '';
    public string $designation = '';
    public ?string $message = null;
    public ?string $email = null;
    public ?string $phone = null;
    public $photo;
    public ?string $existingPhoto = null;
    public bool $is_active = true;
    public int $sort_order = 0;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingTrashed(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'trashed']);
        $this->resetPage();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'designation' => ['required', 'string', 'max:150'],
            'message' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'team-member-form');
    }

    public function edit(int $id): void
    {
        $member = TeamMember::findOrFail($id);

        $this->editingId = $member->id;
        $this->name = $member->name;
        $this->designation = $member->designation;
        $this->message = $member->message;
        $this->email = $member->email;
        $this->phone = $member->phone;
        $this->existingPhoto = $member->photo;
        $this->is_active = $member->is_active;
        $this->sort_order = $member->sort_order;
        $this->photo = null;

        $this->dispatch('open-offcanvas', name: 'team-member-form');
    }

    public function save(): void
    {
        $this->validate();

        $member = $this->editingId
            ? TeamMember::findOrFail($this->editingId)
            : new TeamMember();

        $member->name = $this->name;
        $member->designation = $this->designation;
        $member->message = $this->message;
        $member->email = $this->email;
        $member->phone = $this->phone;
        $member->is_active = $this->is_active;
        $member->sort_order = $this->sort_order;

        if ($this->photo) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $member->photo = $this->photo->store('team', 'public');
        }

        $member->save();

        $this->dispatch('toast', message: $this->editingId ? 'Team member updated.' : 'Team member created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'team-member-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'designation', 'message', 'email', 'phone', 'photo', 'existingPhoto', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-team-member');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-team-member');
    }

    public function delete(): void
    {
        TeamMember::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Team member moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-team-member');
    }

    public function restore(int $id): void
    {
        TeamMember::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Team member restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $member = TeamMember::findOrFail($id);
        $member->update(['is_active' => ! $member->is_active]);
    }

    public function render()
    {
        $members = TeamMember::query()
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.team-members.index', [
            'members' => $members,
        ]);
    }
}
