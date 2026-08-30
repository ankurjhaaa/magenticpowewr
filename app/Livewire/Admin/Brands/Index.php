<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Brands'])]
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
    public ?string $website_url = null;
    public $logo;
    public ?string $existingLogo = null;
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
            'slug' => ['nullable', 'alpha_dash', 'max:170', Rule::unique('brands', 'slug')->ignore($this->editingId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'brand-form');
    }

    public function edit(int $id): void
    {
        $brand = Brand::findOrFail($id);

        $this->editingId = $brand->id;
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->description = $brand->description;
        $this->website_url = $brand->website_url;
        $this->existingLogo = $brand->logo;
        $this->is_active = $brand->is_active;
        $this->sort_order = $brand->sort_order;
        $this->logo = null;

        $this->dispatch('open-offcanvas', name: 'brand-form');
    }

    public function save(): void
    {
        $this->validate();

        $brand = $this->editingId
            ? Brand::findOrFail($this->editingId)
            : new Brand();

        $brand->name = $this->name;
        $brand->description = $this->description;
        $brand->website_url = $this->website_url;
        $brand->is_active = $this->is_active;
        $brand->sort_order = $this->sort_order;

        if ($this->logo) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }

            $brand->logo = $this->logo->store('brands', 'public');
        }

        $brand->slug = $this->slug !== '' ? $this->slug : $brand->generateUniqueSlug();

        $brand->save();

        $this->dispatch('toast', message: $this->editingId ? 'Brand updated.' : 'Brand created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'brand-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'slug', 'description', 'website_url', 'logo', 'existingLogo', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-brand');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-brand');
    }

    public function delete(): void
    {
        Brand::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Brand moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-brand');
    }

    public function restore(int $id): void
    {
        Brand::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Brand restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $brand = Brand::findOrFail($id);
        $brand->update(['is_active' => ! $brand->is_active]);
    }

    public function render()
    {
        $brands = Brand::query()
            ->withCount('products')
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.brands.index', [
            'brands' => $brands,
        ]);
    }
}
