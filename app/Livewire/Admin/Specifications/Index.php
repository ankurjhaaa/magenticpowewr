<?php

namespace App\Livewire\Admin\Specifications;

use App\Models\Specification;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Specifications'])]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed = false;

    public ?int $editingId = null;
    public ?int $deletingId = null;

    public string $name = '';
    public ?string $unit = null;
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
            'name' => ['required', 'string', 'max:100', Rule::unique('specifications', 'name')->ignore($this->editingId)],
            'unit' => ['nullable', 'string', 'max:30'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'specification-form');
    }

    public function edit(int $id): void
    {
        $specification = Specification::findOrFail($id);

        $this->editingId = $specification->id;
        $this->name = $specification->name;
        $this->unit = $specification->unit;
        $this->is_active = $specification->is_active;
        $this->sort_order = $specification->sort_order;

        $this->dispatch('open-offcanvas', name: 'specification-form');
    }

    public function save(): void
    {
        $this->validate();

        $specification = $this->editingId
            ? Specification::findOrFail($this->editingId)
            : new Specification();

        $specification->name = $this->name;
        $specification->unit = $this->unit;
        $specification->is_active = $this->is_active;
        $specification->sort_order = $this->sort_order;
        $specification->save();

        $this->dispatch('toast', message: $this->editingId ? 'Specification updated.' : 'Specification created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'specification-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'unit', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-specification');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-specification');
    }

    public function delete(): void
    {
        Specification::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Specification moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-specification');
    }

    public function restore(int $id): void
    {
        Specification::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Specification restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $specification = Specification::findOrFail($id);
        $specification->update(['is_active' => ! $specification->is_active]);
    }

    public function render()
    {
        $specifications = Specification::query()
            ->withCount('variants')
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.specifications.index', [
            'specifications' => $specifications,
        ]);
    }
}
