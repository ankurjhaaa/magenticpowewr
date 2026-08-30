<?php

namespace App\Livewire\Admin\Applications;

use App\Models\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Applications'])]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed = false;

    public ?int $editingId = null;
    public ?int $deletingId = null;

    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public $icon;
    public ?string $existingIcon = null;
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

    public function updatedSlug(): void
    {
        $this->slug = Str::slug($this->slug);
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
            'slug' => ['nullable', 'alpha_dash', 'max:170', Rule::unique('applications', 'slug')->ignore($this->editingId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'icon' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'application-form');
    }

    public function edit(int $id): void
    {
        $application = Application::findOrFail($id);

        $this->editingId = $application->id;
        $this->name = $application->name;
        $this->slug = $application->slug;
        $this->description = $application->description;
        $this->existingIcon = $application->icon;
        $this->is_active = $application->is_active;
        $this->sort_order = $application->sort_order;
        $this->icon = null;

        $this->dispatch('open-offcanvas', name: 'application-form');
    }

    public function save(): void
    {
        $this->validate();

        $application = $this->editingId
            ? Application::findOrFail($this->editingId)
            : new Application();

        $application->name = $this->name;
        $application->description = $this->description;
        $application->is_active = $this->is_active;
        $application->sort_order = $this->sort_order;

        if ($this->icon) {
            if ($application->icon) {
                Storage::disk('public')->delete($application->icon);
            }

            $application->icon = $this->icon->store('applications', 'public');
        }

        $application->slug = $this->slug !== '' ? $this->slug : $application->generateUniqueSlug();

        $application->save();

        $this->dispatch('toast', message: $this->editingId ? 'Application updated.' : 'Application created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'application-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'slug', 'description', 'icon', 'existingIcon', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-application');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-application');
    }

    public function delete(): void
    {
        Application::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Application moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-application');
    }

    public function restore(int $id): void
    {
        Application::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Application restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $application = Application::findOrFail($id);
        $application->update(['is_active' => ! $application->is_active]);
    }

    public function render()
    {
        $applications = Application::query()
            ->withCount('variants')
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.applications.index', [
            'applications' => $applications,
        ]);
    }
}
