<div>
    <div class="flex items-center justify-between gap-3 mb-6">
        <button
            type="button"
            @click="$dispatch('open-offcanvas', { name: 'specification-filters' })"
            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10M10 18h4"></path>
            </svg>
            Filters
        </button>

        <x-admin.button wire:click="create" variant="primary">
            + Add Specification
        </x-admin.button>
    </div>

    <div wire:loading.delay.class="opacity-60" wire:target="search,status,trashed,previousPage,nextPage,gotoPage,delete,restore,toggleStatus" class="transition-opacity">

    {{-- Desktop table --}}
    <x-admin.table :headers="['Name', 'Unit', 'Used in variants', 'Status', 'Sort', 'Actions']">
        @forelse ($specifications as $specification)
            <tr wire:key="row-{{ $specification->id }}">
                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $specification->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $specification->unit ?? '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $specification->variants_count }}</td>
                <td class="px-4 py-3">
                    @if ($specification->trashed())
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Trashed</span>
                    @else
                        <button wire:click="toggleStatus({{ $specification->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $specification->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $specification->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $specification->sort_order }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3 text-sm">
                        @if ($specification->trashed())
                            <button wire:click="restore({{ $specification->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Restore</button>
                        @else
                            <button wire:click="edit({{ $specification->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDelete({{ $specification->id }})" class="text-red-600 hover:text-red-700 font-semibold cursor-pointer">Delete</button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-600">No specifications found.</td>
            </tr>
        @endforelse
    </x-admin.table>

    {{-- Mobile cards --}}
    <x-admin.card-list>
        @forelse ($specifications as $specification)
            <x-admin.card wire:key="card-{{ $specification->id }}">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $specification->name }}</p>
                        <p class="text-xs text-gray-600">{{ $specification->unit ?? 'No unit' }}</p>
                    </div>
                    @if ($specification->trashed())
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Trashed</span>
                    @else
                        <button wire:click="toggleStatus({{ $specification->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $specification->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $specification->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-300 text-sm">
                    <span class="text-gray-700">{{ $specification->variants_count }} variants &middot; sort {{ $specification->sort_order }}</span>
                    <div class="flex items-center gap-3">
                        @if ($specification->trashed())
                            <button wire:click="restore({{ $specification->id }})" class="text-gray-700 font-semibold cursor-pointer">Restore</button>
                        @else
                            <button wire:click="edit({{ $specification->id }})" class="text-gray-700 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDelete({{ $specification->id }})" class="text-red-600 font-semibold cursor-pointer">Delete</button>
                        @endif
                    </div>
                </div>
            </x-admin.card>
        @empty
            <div class="bg-white border border-gray-300 rounded-lg p-10 text-center text-sm text-gray-600">
                No specifications found.
            </div>
        @endforelse
    </x-admin.card-list>

    <div class="mt-4">
        {{ $specifications->links() }}
    </div>

    </div>

    {{-- Filters offcanvas --}}
    <x-admin.offcanvas name="specification-filters" title="Filters">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    placeholder="Specification name..."
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
        name="specification-form"
        :title="$editingId ? 'Edit Specification' : 'Add Specification'"
        width="w-full sm:w-96"
    >
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" wire:model="name" placeholder="e.g. BMS, Cycle Life, Weight" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit (optional)</label>
                <input type="text" wire:model="unit" placeholder="e.g. A, kg, cycles" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('unit') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
    <x-admin.modal name="delete-specification" max-width="sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete specification?</h3>
        <p class="text-sm text-gray-500 mb-6">This specification will be moved to trash. You can restore it later using the "Show trashed" filter.</p>

        <div class="flex justify-end gap-3">
            <x-admin.button type="button" variant="secondary" wire:click="cancelDelete">Cancel</x-admin.button>
            <x-admin.button type="button" variant="danger" wire:click="delete">Delete</x-admin.button>
        </div>
    </x-admin.modal>
</div>
