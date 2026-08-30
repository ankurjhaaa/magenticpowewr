<div>
    <div class="flex items-center justify-between gap-3 mb-6">
        <button
            type="button"
            @click="$dispatch('open-offcanvas', { name: 'faq-filters' })"
            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10M10 18h4"></path>
            </svg>
            Filters
        </button>

        <x-admin.button wire:click="create" variant="primary">
            + Add FAQ
        </x-admin.button>
    </div>

    <div wire:loading.delay.class="opacity-60" wire:target="search,status,trashed,previousPage,nextPage,gotoPage,delete,restore,toggleStatus" class="transition-opacity">

    {{-- Desktop table --}}
    <x-admin.table :headers="['Question', 'Status', 'Sort', 'Actions']">
        @forelse ($faqs as $faq)
            <tr wire:key="row-{{ $faq->id }}">
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-gray-900 max-w-md truncate">{{ $faq->question }}</p>
                    <p class="text-xs text-gray-600 max-w-md truncate">{{ $faq->answer }}</p>
                </td>
                <td class="px-4 py-3">
                    @if ($faq->trashed())
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Trashed</span>
                    @else
                        <button wire:click="toggleStatus({{ $faq->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $faq->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $faq->sort_order }}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3 text-sm">
                        @if ($faq->trashed())
                            <button wire:click="restore({{ $faq->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Restore</button>
                        @else
                            <button wire:click="edit({{ $faq->id }})" class="text-gray-700 hover:text-gray-900 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDelete({{ $faq->id }})" class="text-red-600 hover:text-red-700 font-semibold cursor-pointer">Delete</button>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-10 text-center text-sm text-gray-600">No FAQs found.</td>
            </tr>
        @endforelse
    </x-admin.table>

    {{-- Mobile cards --}}
    <x-admin.card-list>
        @forelse ($faqs as $faq)
            <x-admin.card wire:key="card-{{ $faq->id }}">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-gray-900 truncate flex-1">{{ $faq->question }}</p>
                    @if ($faq->trashed())
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Trashed</span>
                    @else
                        <button wire:click="toggleStatus({{ $faq->id }})"
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium cursor-pointer {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $faq->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-300 text-sm">
                    <span class="text-gray-700">sort {{ $faq->sort_order }}</span>
                    <div class="flex items-center gap-3">
                        @if ($faq->trashed())
                            <button wire:click="restore({{ $faq->id }})" class="text-gray-700 font-semibold cursor-pointer">Restore</button>
                        @else
                            <button wire:click="edit({{ $faq->id }})" class="text-gray-700 font-semibold cursor-pointer">Edit</button>
                            <button wire:click="confirmDelete({{ $faq->id }})" class="text-red-600 font-semibold cursor-pointer">Delete</button>
                        @endif
                    </div>
                </div>
            </x-admin.card>
        @empty
            <div class="bg-white border border-gray-300 rounded-lg p-10 text-center text-sm text-gray-600">
                No FAQs found.
            </div>
        @endforelse
    </x-admin.card-list>

    <div class="mt-4">
        {{ $faqs->links() }}
    </div>

    </div>

    {{-- Filters offcanvas --}}
    <x-admin.offcanvas name="faq-filters" title="Filters">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    placeholder="Question..."
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
        name="faq-form"
        :title="$editingId ? 'Edit FAQ' : 'Add FAQ'"
        width="w-full sm:w-[28rem] lg:w-[32rem]"
    >
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                <input type="text" wire:model="question" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('question') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                <textarea wire:model="answer" rows="5" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"></textarea>
                @error('answer') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
    <x-admin.modal name="delete-faq" max-width="sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete FAQ?</h3>
        <p class="text-sm text-gray-500 mb-6">This FAQ will be moved to trash. You can restore it later using the "Show trashed" filter.</p>

        <div class="flex justify-end gap-3">
            <x-admin.button type="button" variant="secondary" wire:click="cancelDelete">Cancel</x-admin.button>
            <x-admin.button type="button" variant="danger" wire:click="delete">Delete</x-admin.button>
        </div>
    </x-admin.modal>
</div>
