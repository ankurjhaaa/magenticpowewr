<?php

namespace App\Livewire\Admin\Banners;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Banners'])]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public string $status = '';
    public bool $trashed = false;

    public ?int $editingId = null;
    public ?int $deletingId = null;

    public ?string $title = null;
    public ?string $subtitle = null;
    public ?string $button_text = null;
    public ?string $button_url = null;
    public $image;
    public ?string $existingImage = null;
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
            'title' => ['nullable', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:50'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'image' => [$this->editingId ? 'nullable' : 'required', 'image', 'max:4096'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->dispatch('open-offcanvas', name: 'banner-form');
    }

    public function edit(int $id): void
    {
        $banner = Banner::findOrFail($id);

        $this->editingId = $banner->id;
        $this->title = $banner->title;
        $this->subtitle = $banner->subtitle;
        $this->button_text = $banner->button_text;
        $this->button_url = $banner->button_url;
        $this->existingImage = $banner->image;
        $this->is_active = $banner->is_active;
        $this->sort_order = $banner->sort_order;
        $this->image = null;

        $this->dispatch('open-offcanvas', name: 'banner-form');
    }

    public function save(): void
    {
        $this->validate();

        $banner = $this->editingId
            ? Banner::findOrFail($this->editingId)
            : new Banner();

        $banner->title = $this->title;
        $banner->subtitle = $this->subtitle;
        $banner->button_text = $this->button_text;
        $banner->button_url = $this->button_url;
        $banner->is_active = $this->is_active;
        $banner->sort_order = $this->sort_order;

        if ($this->image) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }

            $banner->image = $this->image->store('banners', 'public');
        }

        $banner->save();

        $this->dispatch('toast', message: $this->editingId ? 'Banner updated.' : 'Banner created.', type: 'success');

        $this->closeForm();
    }

    public function closeForm(): void
    {
        $this->dispatch('close-offcanvas', name: 'banner-form');
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'subtitle', 'button_text', 'button_url', 'image', 'existingImage', 'is_active', 'sort_order']);
        $this->resetValidation();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal', name: 'delete-banner');
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
        $this->dispatch('close-modal', name: 'delete-banner');
    }

    public function delete(): void
    {
        Banner::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        $this->dispatch('toast', message: 'Banner moved to trash.', type: 'success');
        $this->dispatch('close-modal', name: 'delete-banner');
    }

    public function restore(int $id): void
    {
        Banner::onlyTrashed()->findOrFail($id)->restore();

        $this->dispatch('toast', message: 'Banner restored.', type: 'success');
    }

    public function toggleStatus(int $id): void
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => ! $banner->is_active]);
    }

    public function render()
    {
        $banners = Banner::query()
            ->when($this->trashed, fn ($query) => $query->onlyTrashed())
            ->when($this->search !== '', fn ($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->when($this->status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($this->status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.banners.index', [
            'banners' => $banners,
        ]);
    }
}
