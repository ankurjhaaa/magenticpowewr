<div>
    <div class="flex items-center justify-between gap-3 mb-6">
        <button
            type="button"
            @click="$dispatch('open-offcanvas', { name: 'product-filters' })"
            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10M10 18h4"></path>
            </svg>
            Filters
        </button>

        @if ($categories->isEmpty() || $brands->isEmpty())
            <span class="text-sm text-gray-500">Add a Category and Brand first to create a product.</span>
        @else
            <x-admin.button wire:click="create" variant="primary">
                + Add Product
            </x-admin.button>
        @endif
    </div>

    <div wire:loading.delay.class="opacity-60" wire:target="search,status,trashed,previousPage,nextPage,gotoPage,delete,restore,toggleStatus" class="transition-opacity">

    {{-- Desktop table --}}
    <x-admin.table :headers="['Product', 'Category', 'Brand', 'Variants', 'Status', 'Sort', 'Actions']">
        @forelse ($products as $product)
            <tr wire:key="row-{{ $product->id }}">
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                    <p class="text-xs text-gray-600">{{ $product->slug }}</p>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $product->category?->name ?? '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $product->brand?->name ?? '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $product->variants_count }}</td>
                <td class="px-4 py-3">
                    @if ($product->trashed())
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Trashed</span>
                    @else
                        <button wire:click="toggleStatus({{ $product->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $product->sort_order }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3 text-sm">
                        @if ($product->trashed())
                            <button wire:click="restore({{ $product->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Restore</button>
                        @else
                            <a href="{{ route('admin.products.manage', $product) }}" class="text-gray-900 hover:underline font-semibold">Manage</a>
                            <button wire:click="edit({{ $product->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDelete({{ $product->id }})" class="text-red-600 hover:text-red-700 font-semibold cursor-pointer">Delete</button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-10 text-center text-sm text-gray-600">No products found.</td>
            </tr>
        @endforelse
    </x-admin.table>

    {{-- Mobile cards --}}
    <x-admin.card-list>
        @forelse ($products as $product)
            <x-admin.card wire:key="card-{{ $product->id }}">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                        <p class="text-xs text-gray-600 truncate">{{ $product->category?->name ?? '—' }} &middot; {{ $product->brand?->name ?? '—' }}</p>
                    </div>
                    @if ($product->trashed())
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Trashed</span>
                    @else
                        <button wire:click="toggleStatus({{ $product->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-300 text-sm">
                    <span class="text-gray-700">{{ $product->variants_count }} variants &middot; sort {{ $product->sort_order }}</span>
                    <div class="flex items-center gap-3">
                        @if ($product->trashed())
                            <button wire:click="restore({{ $product->id }})" class="text-gray-700 font-semibold cursor-pointer">Restore</button>
                        @else
                            <a href="{{ route('admin.products.manage', $product) }}" class="text-gray-900 font-semibold">Manage</a>
                            <button wire:click="edit({{ $product->id }})" class="text-gray-700 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDelete({{ $product->id }})" class="text-red-600 font-semibold cursor-pointer">Delete</button>
                        @endif
                    </div>
                </div>
            </x-admin.card>
        @empty
            <div class="bg-white border border-gray-300 rounded-lg p-10 text-center text-sm text-gray-600">
                No products found.
            </div>
        @endforelse
    </x-admin.card-list>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    </div>

    {{-- Filters offcanvas --}}
    <x-admin.offcanvas name="product-filters" title="Filters">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    placeholder="Product name..."
                    class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="status" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600 select-none">
                <input type="checkbox" wire:model.live="trashed" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                Show trashed
            </label>
        </div>

        <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
            <x-admin.button type="button" variant="secondary" wire:click="clearFilters" class="flex-1">
                Clear
            </x-admin.button>
            <button
                type="button"
                @click="show = false"
                class="flex-1 inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 cursor-pointer"
            >
                Apply
            </button>
        </div>
    </x-admin.offcanvas>

    {{-- Create / Edit form offcanvas --}}
    <x-admin.offcanvas
        name="product-form"
        :title="$editingId ? 'Edit Product' : 'Add Product'"
        width="w-full sm:w-[28rem] lg:w-[32rem]"
    >
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" wire:model="name" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" wire:model="slug" placeholder="Auto-generated from name if left blank" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select wire:model="category_id" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select wire:model="brand_id" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        <option value="">Select brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                <input type="text" wire:model="short_description" maxlength="300" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('short_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea wire:model="description" rows="4" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"></textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" wire:model="sort_order" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                    @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-end pb-2.5">
                    <label class="flex items-center gap-2 text-sm text-gray-600 select-none">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                        Active
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-admin.button type="button" variant="secondary" wire:click="closeForm">Cancel</x-admin.button>
                <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                    {{ $editingId ? 'Update' : 'Create' }}
                </x-admin.button>
            </div>
        </form>
    </x-admin.offcanvas>

    {{-- Delete confirmation modal --}}
    <x-admin.modal name="delete-product" max-width="sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete product?</h3>
        <p class="text-sm text-gray-500 mb-6">This product and its variants will be moved to trash. You can restore it later using the "Show trashed" filter.</p>

        <div class="flex justify-end gap-3">
            <x-admin.button type="button" variant="secondary" wire:click="cancelDelete">Cancel</x-admin.button>
            <x-admin.button type="button" variant="danger" wire:click="delete">Delete</x-admin.button>
        </div>
    </x-admin.modal>
</div>
