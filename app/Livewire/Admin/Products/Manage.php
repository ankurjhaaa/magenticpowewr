<?php

namespace App\Livewire\Admin\Products;

use App\Models\Application;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Specification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin', ['title' => 'Manage Product'])]
class Manage extends Component
{
    use WithFileUploads;

    public Product $product;

    // Product fields
    public string $name = '';
    public string $slug = '';
    public ?int $category_id = null;
    public ?int $brand_id = null;
    public ?string $short_description = null;
    public ?string $description = null;
    public bool $is_active = true;
    public int $sort_order = 0;

    public $newProductImage;

    // Variant form state
    public ?int $editingVariantId = null;
    public ?int $deletingVariantId = null;

    public string $v_sku = '';
    public string $v_name = '';
    public string $v_slug = '';
    public ?string $v_voltage = null;
    public ?string $v_capacity = null;
    public ?string $v_chemistry = null;
    public bool $v_is_default = false;
    public bool $v_is_active = true;
    public int $v_sort_order = 0;

    public array $specValues = [];
    public array $selectedApplications = [];

    public $newVariantImage;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->is_active = $product->is_active;
        $this->sort_order = $product->sort_order;
    }

    public function updatedSlug(): void
    {
        $this->slug = Str::slug($this->slug);
    }

    public function updatedVSlug(): void
    {
        $this->v_slug = Str::slug($this->v_slug);
    }

    #[Computed]
    public function categories()
    {
        return Category::query()->orderBy('sort_order')->orderBy('name')->get();
    }

    #[Computed]
    public function brands()
    {
        return Brand::query()->orderBy('sort_order')->orderBy('name')->get();
    }

    #[Computed]
    public function specifications()
    {
        return Specification::active()->ordered()->get();
    }

    #[Computed]
    public function applications()
    {
        return Application::active()->ordered()->get();
    }

    #[Computed]
    public function editingVariant(): ?ProductVariant
    {
        if (! $this->editingVariantId) {
            return null;
        }

        return $this->product->variants()
            ->with(['images', 'specifications', 'applications'])
            ->find($this->editingVariantId);
    }

    protected function productRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'alpha_dash', 'max:220', Rule::unique('products', 'slug')->ignore($this->product->id)],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'short_description' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function saveProduct(): void
    {
        $this->validate($this->productRules());

        $this->product->category_id = $this->category_id;
        $this->product->brand_id = $this->brand_id;
        $this->product->name = $this->name;
        $this->product->short_description = $this->short_description;
        $this->product->description = $this->description;
        $this->product->is_active = $this->is_active;
        $this->product->sort_order = $this->sort_order;
        $this->product->slug = $this->slug !== '' ? $this->slug : $this->product->generateUniqueSlug();
        $this->product->save();

        $this->dispatch('toast', message: 'Product details updated.', type: 'success');
    }

    public function uploadProductImage(): void
    {
        $this->validate(['newProductImage' => ['required', 'image', 'max:2048']]);

        $this->product->images()->create([
            'image_path' => $this->newProductImage->store('products', 'public'),
            'is_primary' => $this->product->images()->count() === 0,
            'sort_order' => $this->product->images()->count(),
        ]);

        $this->reset('newProductImage');
        $this->dispatch('toast', message: 'Product image uploaded.', type: 'success');
    }

    public function deleteProductImage(int $imageId): void
    {
        $image = $this->product->images()->findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $this->product->images()->first()?->update(['is_primary' => true]);
        }
    }

    public function setPrimaryProductImage(int $imageId): void
    {
        $this->product->images()->update(['is_primary' => false]);
        $this->product->images()->where('id', $imageId)->update(['is_primary' => true]);
    }

    public function createVariant(): void
    {
        $this->resetVariantForm();
        $this->dispatch('open-offcanvas', name: 'variant-form');
    }

    public function editVariant(int $id): void
    {
        $variant = $this->product->variants()->with(['specifications', 'applications'])->findOrFail($id);

        $this->editingVariantId = $variant->id;
        $this->v_sku = $variant->sku;
        $this->v_name = $variant->name;
        $this->v_slug = $variant->slug;
        $this->v_voltage = $variant->voltage;
        $this->v_capacity = $variant->capacity;
        $this->v_chemistry = $variant->chemistry;
        $this->v_is_default = $variant->is_default;
        $this->v_is_active = $variant->is_active;
        $this->v_sort_order = $variant->sort_order;

        $this->specValues = $variant->specifications->mapWithKeys(
            fn ($spec) => [$spec->id => $spec->pivot->value]
        )->toArray();
        $this->selectedApplications = $variant->applications->pluck('id')->toArray();

        $this->dispatch('open-offcanvas', name: 'variant-form');
    }

    protected function variantRules(): array
    {
        return [
            'v_sku' => ['required', 'string', 'max:100', Rule::unique('product_variants', 'sku')->ignore($this->editingVariantId)],
            'v_name' => ['required', 'string', 'max:150'],
            'v_slug' => ['nullable', 'alpha_dash', 'max:170'],
            'v_voltage' => ['nullable', 'string', 'max:50'],
            'v_capacity' => ['nullable', 'string', 'max:50'],
            'v_chemistry' => ['nullable', 'string', 'max:50'],
            'v_is_default' => ['boolean'],
            'v_is_active' => ['boolean'],
            'v_sort_order' => ['integer', 'min:0'],
        ];
    }

    public function saveVariant(): void
    {
        $this->validate($this->variantRules());

        $isNew = $this->editingVariantId === null;

        $variant = $isNew
            ? new ProductVariant(['product_id' => $this->product->id])
            : $this->product->variants()->findOrFail($this->editingVariantId);

        $variant->product_id = $this->product->id;
        $variant->sku = $this->v_sku;
        $variant->name = $this->v_name;
        $variant->voltage = $this->v_voltage;
        $variant->capacity = $this->v_capacity;
        $variant->chemistry = $this->v_chemistry;
        $variant->is_active = $this->v_is_active;
        $variant->sort_order = $this->v_sort_order;

        if ($this->v_is_default) {
            $this->product->variants()->update(['is_default' => false]);
        }
        $variant->is_default = $this->v_is_default;

        $variant->slug = $this->v_slug !== '' ? $this->v_slug : $variant->generateUniqueSlug();
        $variant->save();

        $syncData = collect($this->specValues)
            ->filter(fn ($value) => trim((string) $value) !== '')
            ->mapWithKeys(fn ($value, $specId) => [(int) $specId => ['value' => $value]])
            ->toArray();
        $variant->specifications()->sync($syncData);
        $variant->applications()->sync($this->selectedApplications);

        $this->editingVariantId = $variant->id;
        unset($this->editingVariant);

        $this->dispatch('toast', message: $isNew ? 'Variant created. You can now add images.' : 'Variant updated.', type: 'success');
    }

    public function closeVariantForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'variant-form');
        $this->resetVariantForm();
    }

    protected function resetVariantForm(): void
    {
        $this->reset([
            'editingVariantId', 'v_sku', 'v_name', 'v_slug', 'v_voltage', 'v_capacity',
            'v_chemistry', 'v_is_default', 'v_is_active', 'v_sort_order', 'specValues', 'selectedApplications',
        ]);
        $this->resetValidation();
        unset($this->editingVariant);
    }

    public function uploadVariantImage(): void
    {
        $this->validate(['newVariantImage' => ['required', 'image', 'max:2048']]);

        $variant = $this->product->variants()->findOrFail($this->editingVariantId);

        $variant->images()->create([
            'image_path' => $this->newVariantImage->store('variants', 'public'),
            'is_primary' => $variant->images()->count() === 0,
            'sort_order' => $variant->images()->count(),
        ]);

        $this->reset('newVariantImage');
        unset($this->editingVariant);
    }

    public function deleteVariantImage(int $imageId): void
    {
        $variant = $this->product->variants()->findOrFail($this->editingVariantId);
        $image = $variant->images()->findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $variant->images()->first()?->update(['is_primary' => true]);
        }

        unset($this->editingVariant);
    }

    public function setPrimaryVariantImage(int $imageId): void
    {
        $variant = $this->product->variants()->findOrFail($this->editingVariantId);
        $variant->images()->update(['is_primary' => false]);
        $variant->images()->where('id', $imageId)->update(['is_primary' => true]);

        unset($this->editingVariant);
    }

    public function confirmDeleteVariant(int $id): void
    {
        $this->deletingVariantId = $id;
        $this->dispatch('open-modal', name: 'delete-variant');
    }

    public function cancelDeleteVariant(): void
    {
        $this->deletingVariantId = null;
        $this->dispatch('close-modal', name: 'delete-variant');
    }

    public function deleteVariant(): void
    {
        $this->product->variants()->findOrFail($this->deletingVariantId)->delete();

        $this->deletingVariantId = null;
        $this->dispatch('toast', message: 'Variant moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-variant');
    }

    public function restoreVariant(int $id): void
    {
        $this->product->variants()->onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Variant restored.', type: 'success');
    }

    public function render()
    {
        $variants = $this->product->variants()
            ->withCount(['images', 'specifications', 'applications'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $trashedVariants = $this->product->variants()->onlyTrashed()->get();

        return view('livewire.admin.products.manage', [
            'variants' => $variants,
            'trashedVariants' => $trashedVariants,
        ]);
    }
}
