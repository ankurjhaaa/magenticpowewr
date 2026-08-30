<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Products'])]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed = false;

    public ?int $editingId = null;
    public ?int $deletingId = null;

    public string $name = '';
    public string $slug = '';
    public ?int $category_id = null;
    public ?int $brand_id = null;
    public ?string $short_description = null;
    public ?string $description = null;
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
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'alpha_dash', 'max:220', Rule::unique('products', 'slug')->ignore($this->editingId)],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'short_description' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'product-form');
    }

    public function edit(int $id): void
    {
        $product = Product::findOrFail($id);

        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->is_active = $product->is_active;
        $this->sort_order = $product->sort_order;

        $this->dispatch('open-offcanvas', name: 'product-form');
    }

    public function save(): void
    {
        $this->validate();

        $product = $this->editingId
            ? Product::findOrFail($this->editingId)
            : new Product();

        $product->category_id = $this->category_id;
        $product->brand_id = $this->brand_id;
        $product->name = $this->name;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->is_active = $this->is_active;
        $product->sort_order = $this->sort_order;
        $product->slug = $this->slug !== '' ? $this->slug : $product->generateUniqueSlug();
        $product->save();

        $this->dispatch('toast', message: $this->editingId ? 'Product updated.' : 'Product created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'product-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'slug', 'category_id', 'brand_id', 'short_description', 'description', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-product');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-product');
    }

    public function delete(): void
    {
        Product::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Product moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-product');
    }

    public function restore(int $id): void
    {
        Product::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Product restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => ! $product->is_active]);
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'brand'])
            ->withCount('variants')
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.products.index', [
            'products' => $products,
            'categories' => Category::query()->orderBy('sort_order')->orderBy('name')->get(),
            'brands' => Brand::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
