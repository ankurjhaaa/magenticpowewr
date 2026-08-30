<div class="space-y-8 max-w-5xl">
    <div>
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 inline-flex items-center gap-1">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Products
        </a>
    </div>

    {{-- Product details --}}
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Product Details</h2>

        <form wire:submit="saveProduct" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" wire:model="name" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" wire:model="slug" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select wire:model="category_id" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        <option value="">Select category</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select wire:model="brand_id" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        <option value="">Select brand</option>
                        @foreach ($this->brands as $brand)
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

            <div class="flex justify-end">
                <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="saveProduct">
                    Save Product
                </x-admin.button>
            </div>
        </form>
    </div>

    {{-- Product images --}}
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Product Images</h2>

        <div class="flex flex-wrap gap-4 mb-4">
            @foreach ($product->images as $image)
                <div class="relative w-24 h-24 group">
                    <img src="{{ Storage::url($image->image_path) }}" class="w-24 h-24 rounded-lg object-cover border border-gray-300">
                    @if ($image->is_primary)
                        <span class="absolute top-1 left-1 bg-gray-900 text-white text-[10px] px-1.5 py-0.5 rounded">Primary</span>
                    @else
                        <button wire:click="setPrimaryProductImage({{ $image->id }})" class="absolute top-1 left-1 bg-white/90 text-gray-700 text-[10px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 cursor-pointer">
                            Set primary
                        </button>
                    @endif
                    <button wire:click="deleteProductImage({{ $image->id }})" wire:confirm="Delete this image?" class="absolute top-1 right-1 bg-white/90 text-red-600 rounded-full w-5 h-5 flex items-center justify-center cursor-pointer">
                        &times;
                    </button>
                </div>
            @endforeach
        </div>

        <form wire:submit="uploadProductImage" class="flex items-center gap-3">
            <input type="file" wire:model="newProductImage" accept="image/*" class="text-sm text-gray-600">
            <x-admin.button type="submit" variant="secondary" wire:loading.attr="disabled" wire:target="newProductImage,uploadProductImage">
                Upload
            </x-admin.button>
        </form>
        <div wire:loading wire:target="newProductImage" class="text-xs text-gray-400 mt-1">Uploading...</div>
        @error('newProductImage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Variants --}}
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-900">Variants</h2>
            <x-admin.button wire:click="createVariant" variant="primary">
                + Add Variant
            </x-admin.button>
        </div>

        <x-admin.table :headers="['SKU', 'Variant', 'Voltage / Capacity', 'Default', 'Status', 'Actions']">
            @forelse ($variants as $variant)
                <tr wire:key="variant-row-{{ $variant->id }}">
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $variant->sku }}</td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $variant->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $variant->voltage }} {{ $variant->capacity }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $variant->is_default ? 'Yes' : '—' }}</td>
                    <td class="px-4 py-3">
                        <button wire:click="editVariant({{ $variant->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $variant->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $variant->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3 text-sm">
                            <button wire:click="editVariant({{ $variant->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDeleteVariant({{ $variant->id }})" class="text-red-600 hover:text-red-700 font-semibold cursor-pointer">Delete</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-600">No variants yet. Add the first one.</td>
                </tr>
            @endforelse
        </x-admin.table>

        <x-admin.card-list>
            @forelse ($variants as $variant)
                <x-admin.card wire:key="variant-card-{{ $variant->id }}">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $variant->name }}</p>
                            <p class="text-xs text-gray-600">{{ $variant->sku }} &middot; {{ $variant->voltage }} {{ $variant->capacity }}</p>
                        </div>
                        <button wire:click="editVariant({{ $variant->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $variant->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $variant->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-300 text-sm">
                        <span class="text-gray-700">{{ $variant->is_default ? 'Default variant' : '' }}</span>
                        <div class="flex items-center gap-3">
                            <button wire:click="editVariant({{ $variant->id }})" class="text-gray-700 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDeleteVariant({{ $variant->id }})" class="text-red-600 font-semibold cursor-pointer">Delete</button>
                        </div>
                    </div>
                </x-admin.card>
            @empty
                <div class="bg-white border border-gray-300 rounded-lg p-10 text-center text-sm text-gray-600">
                    No variants yet. Add the first one.
                </div>
            @endforelse
        </x-admin.card-list>

        @if ($trashedVariants->isNotEmpty())
            <div class="mt-6 pt-4 border-t border-gray-200">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Trashed variants</p>
                <div class="space-y-2">
                    @foreach ($trashedVariants as $variant)
                        <div class="flex items-center justify-between text-sm bg-gray-50 rounded-lg px-3 py-2">
                            <span class="text-gray-600">{{ $variant->name }} ({{ $variant->sku }})</span>
                            <button wire:click="restoreVariant({{ $variant->id }})" class="text-gray-900 font-semibold cursor-pointer">Restore</button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Variant form offcanvas --}}
    <x-admin.offcanvas
        name="variant-form"
        :title="$editingVariantId ? 'Edit Variant' : 'Add Variant'"
        width="w-full sm:w-[30rem] lg:w-[36rem]"
    >
        <div x-data="{ tab: 'details' }">
            <div class="flex gap-5 border-b border-gray-200 mb-5">
                <button type="button" @click="tab = 'details'"
                    :class="tab === 'details' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="pb-2.5 text-sm font-semibold border-b-2 cursor-pointer">
                    Details
                </button>
                @if ($editingVariantId && $this->editingVariant)
                    <button type="button" @click="tab = 'images'"
                        :class="tab === 'images' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-2.5 text-sm font-semibold border-b-2 cursor-pointer">
                        Images
                    </button>
                    <button type="button" @click="tab = 'specifications'"
                        :class="tab === 'specifications' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-2.5 text-sm font-semibold border-b-2 cursor-pointer">
                        Specifications
                    </button>
                    <button type="button" @click="tab = 'applications'"
                        :class="tab === 'applications' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="pb-2.5 text-sm font-semibold border-b-2 cursor-pointer">
                        Applications
                    </button>
                @endif
            </div>

            {{-- Details tab --}}
            <div x-show="tab === 'details'">
                <form wire:submit="saveVariant" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                            <input type="text" wire:model="v_sku" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                            @error('v_sku') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" wire:model="v_name" placeholder="e.g. 48V 30Ah" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                            @error('v_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" wire:model="v_slug" placeholder="Auto-generated from name if left blank" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        @error('v_slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Voltage</label>
                            <input type="text" wire:model="v_voltage" placeholder="48V" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                            <input type="text" wire:model="v_capacity" placeholder="30Ah" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chemistry</label>
                            <input type="text" wire:model="v_chemistry" placeholder="LFP" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                            <input type="number" wire:model="v_sort_order" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                        </div>
                        <div class="flex items-end pb-2.5">
                            <label class="flex items-center gap-2 text-sm text-gray-600 select-none">
                                <input type="checkbox" wire:model="v_is_active" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                Active
                            </label>
                        </div>
                        <div class="flex items-end pb-2.5">
                            <label class="flex items-center gap-2 text-sm text-gray-600 select-none">
                                <input type="checkbox" wire:model="v_is_default" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                Default variant
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" @click="show = false" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 cursor-pointer">
                            Close
                        </button>
                        <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="saveVariant">
                            {{ $editingVariantId ? 'Save Changes' : 'Create Variant' }}
                        </x-admin.button>
                    </div>
                </form>
            </div>

            @if ($editingVariantId && $this->editingVariant)
                {{-- Images tab --}}
                <div x-show="tab === 'images'" x-cloak>
                    <div class="flex flex-wrap gap-3 mb-4">
                        @forelse ($this->editingVariant->images as $image)
                            <div class="relative w-24 h-24 group">
                                <img src="{{ Storage::url($image->image_path) }}" class="w-24 h-24 rounded-lg object-cover border border-gray-300">
                                @if ($image->is_primary)
                                    <span class="absolute top-1 left-1 bg-gray-900 text-white text-[10px] px-1.5 py-0.5 rounded">Primary</span>
                                @else
                                    <button wire:click="setPrimaryVariantImage({{ $image->id }})" class="absolute top-1 left-1 bg-white/90 text-gray-700 text-[10px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 cursor-pointer">
                                        Set primary
                                    </button>
                                @endif
                                <button wire:click="deleteVariantImage({{ $image->id }})" wire:confirm="Delete this image?" class="absolute top-1 right-1 bg-white/90 text-red-600 rounded-full w-5 h-5 flex items-center justify-center cursor-pointer">
                                    &times;
                                </button>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No images uploaded yet.</p>
                        @endforelse
                    </div>
                    <form wire:submit="uploadVariantImage" class="flex items-center gap-3">
                        <input type="file" wire:model="newVariantImage" accept="image/*" class="text-sm text-gray-600">
                        <x-admin.button type="submit" variant="secondary" wire:loading.attr="disabled" wire:target="newVariantImage,uploadVariantImage">
                            Upload
                        </x-admin.button>
                    </form>
                    <div wire:loading wire:target="newVariantImage" class="text-xs text-gray-400 mt-1">Uploading...</div>
                    @error('newVariantImage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Specifications tab --}}
                <div x-show="tab === 'specifications'" x-cloak>
                    <form wire:submit="saveVariant" class="space-y-4">
                        <div class="space-y-2">
                            @forelse ($this->specifications as $spec)
                                <div class="flex items-center gap-3">
                                    <span class="w-32 shrink-0 text-sm text-gray-700">{{ $spec->name }}{{ $spec->unit ? " ({$spec->unit})" : '' }}</span>
                                    <input type="text" wire:model="specValues.{{ $spec->id }}" placeholder="Value"
                                        class="flex-1 rounded-lg border border-gray-300 px-3 py-1.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No specifications defined yet. Add some from the Specifications page.</p>
                            @endforelse
                        </div>
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="saveVariant">
                                Save Specifications
                            </x-admin.button>
                        </div>
                    </form>
                </div>

                {{-- Applications tab --}}
                <div x-show="tab === 'applications'" x-cloak>
                    <form wire:submit="saveVariant" class="space-y-4">
                        <div class="flex flex-wrap gap-3">
                            @forelse ($this->applications as $application)
                                <label class="flex items-center gap-2 text-sm text-gray-700 select-none">
                                    <input type="checkbox" wire:model="selectedApplications" value="{{ $application->id }}" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                    {{ $application->name }}
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">No applications defined yet. Add some from the Applications page.</p>
                            @endforelse
                        </div>
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="saveVariant">
                                Save Applications
                            </x-admin.button>
                        </div>
                    </form>
                </div>
            @else
                <p class="text-xs text-gray-400 mt-2">
                    Save the variant details first to unlock Images, Specifications and Applications.
                </p>
            @endif
        </div>
    </x-admin.offcanvas>

    {{-- Delete variant confirmation --}}
    <x-admin.modal name="delete-variant" max-width="sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete variant?</h3>
        <p class="text-sm text-gray-500 mb-6">This variant and its images will be moved to trash.</p>

        <div class="flex justify-end gap-3">
            <x-admin.button type="button" variant="secondary" wire:click="cancelDeleteVariant">Cancel</x-admin.button>
            <x-admin.button type="button" variant="danger" wire:click="deleteVariant">Delete</x-admin.button>
        </div>
    </x-admin.modal>
</div>
