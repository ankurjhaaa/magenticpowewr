<?php
namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


#[Layout('layouts.admin', ['title' => 'Categories'])]

class Index extends Component
{

    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed  = false;

    public ?int $editingId  = null;
    public ?int $deletingId = null;

    public string $name         = '';
    public string $slug         = '';
    public ?string $description = null;
    public $image;
    public ?string $existingImage = null;
    public bool $is_active        = true;
    public int $sort_order        = 0;


    public function updatingSearch()
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

    protected function rules(): array
    {
        return [
             'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'alpha_dash', 'max:170', Rule::unique('categories', 'slug')->ignore($this->editingId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],

        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'category-form');
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'trashed']);
        $this->resetPage();
    }

     public function edit(int $id): void
    {
        $category = Category::findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->existingImage = $category->image;
        $this->is_active = $category->is_active;
        $this->sort_order = $category->sort_order;
        $this->image = null;

        $this->dispatch('open-offcanvas', name: 'category-form');
    }

    public function save(): void

    {
          $this->validate();

        $category = $this->editingId
            ? Category::findOrFail($this->editingId)
            : new Category();

        $category->name = $this->name;
        $category->description = $this->description;
        $category->is_active = $this->is_active;
        $category->sort_order = $this->sort_order;

        if ($this->image) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->image = $this->image->store('categories', 'public');
        }

        $category->slug = $this->slug !== '' ? $this->slug : $category->generateUniqueSlug();

        $category->save();

        $this->dispatch('toast', message: $this->editingId ? 'Category updated.' : 'Category created.', type: 'success');

        $this->closeForm();

    }

        public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'category-form');
        $this->resetForm();
    }

        protected function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'slug', 'description', 'image', 'existingImage', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

        public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-category');
    }

        public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-category');
    }

        public function delete(): void
    {
        Category::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Category moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-category');
    }

        public function restore(int $id): void
    {
        Category::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Category restored.', type: 'success');
    }

        public function toggleStatus(int $id): void
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => ! $category->is_active]);
    }

     public function render()
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.categories.index', [
            'categories' => $categories,
        ]);
    }




   
}
