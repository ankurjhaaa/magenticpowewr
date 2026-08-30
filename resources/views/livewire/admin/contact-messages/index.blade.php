<div>
    <div class="flex items-center justify-between gap-3 mb-6">
        <button
            type="button"
            @click="$dispatch('open-offcanvas', { name: 'message-filters' })"
            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10M10 18h4"></path>
            </svg>
            Filters
        </button>
    </div>

    <div wire:loading.delay.class="opacity-60" wire:target="search,status,previousPage,nextPage,gotoPage,updateStatus" class="transition-opacity">

    {{-- Desktop table --}}
    <x-admin.table :headers="['Name', 'Contact', 'Subject', 'Status', 'Received', 'Actions']">
        @forelse ($messages as $message)
            <tr wire:key="row-{{ $message->id }}">
                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $message->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700">
                    {{ $message->email }}{{ $message->phone ? ' · '.$message->phone : '' }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ $message->subject ?? '—' }}</td>
                <td class="px-4 py-3">
                    <x-admin.status-select :status="$message->status" :action="'updateStatus(' . $message->id . ', $event.target.value)'" />
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">{{ $message->created_at->diffForHumans() }}</td>
                <td class="px-4 py-3">
                    <button wire:click="view({{ $message->id }})" class="text-gray-700 hover:text-gray-900 font-semibold text-sm cursor-pointer">View</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-600">No contact messages yet.</td>
            </tr>
        @endforelse
    </x-admin.table>

    {{-- Mobile cards --}}
    <x-admin.card-list>
        @forelse ($messages as $message)
            <x-admin.card wire:key="card-{{ $message->id }}" wire:click="view({{ $message->id }})" class="cursor-pointer">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $message->name }}</p>
                        <p class="text-xs text-gray-600">{{ $message->email }}</p>
                    </div>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                        {{ match($message->status) {
                            'new' => 'bg-blue-50 text-blue-700 border border-blue-200',
                            'read' => 'bg-slate-50 text-slate-700 border border-slate-200',
                            'replied' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                            'closed' => 'bg-gray-50 text-gray-500 border border-gray-200',
                        } }}">
                        {{ ucfirst($message->status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-gray-300 text-sm">
                    <span class="text-gray-700 truncate">{{ $message->subject ?? '—' }}</span>
                    <span class="text-gray-500 text-xs">{{ $message->created_at->diffForHumans() }}</span>
                </div>
            </x-admin.card>
        @empty
            <div class="bg-white border border-gray-300 rounded-lg p-10 text-center text-sm text-gray-600">
                No contact messages yet.
            </div>
        @endforelse
    </x-admin.card-list>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>

    </div>

    {{-- Filters offcanvas --}}
    <x-admin.offcanvas name="message-filters" title="Filters">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    placeholder="Name, email, phone or subject..."
                    class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="status" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                    <option value="">All</option>
                    <option value="new">New</option>
                    <option value="read">Read</option>
                    <option value="replied">Replied</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
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

    {{-- View detail modal --}}
    <x-admin.modal name="message-view" max-width="lg">
        @if ($viewing)
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Contact Message</h3>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                    {{ match($viewing->status) {
                        'new' => 'bg-blue-50 text-blue-700 border border-blue-200',
                        'read' => 'bg-slate-50 text-slate-700 border border-slate-200',
                        'replied' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                        'closed' => 'bg-gray-50 text-gray-500 border border-gray-200',
                    } }}">
                    {{ ucfirst($viewing->status) }}
                </span>
            </div>

            <dl class="space-y-3 text-sm">
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">Name</dt>
                    <dd class="col-span-2 text-gray-900">{{ $viewing->name }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">Email</dt>
                    <dd class="col-span-2 text-gray-900">{{ $viewing->email }}</dd>
                </div>
                @if ($viewing->phone)
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Phone</dt>
                        <dd class="col-span-2 text-gray-900">{{ $viewing->phone }}</dd>
                    </div>
                @endif
                @if ($viewing->subject)
                    <div class="grid grid-cols-3 gap-2">
                        <dt class="text-gray-500">Subject</dt>
                        <dd class="col-span-2 text-gray-900">{{ $viewing->subject }}</dd>
                    </div>
                @endif
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">Received</dt>
                    <dd class="col-span-2 text-gray-900">{{ $viewing->created_at->format('d M Y, h:i A') }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <dt class="text-gray-500">Message</dt>
                    <dd class="col-span-2 text-gray-900 whitespace-pre-line">{{ $viewing->message }}</dd>
                </div>
            </dl>

            <div class="flex justify-between items-center gap-3 pt-6 mt-6 border-t border-gray-200">
                <x-admin.status-select :status="$viewing->status" :action="'updateStatus(' . $viewing->id . ', $event.target.value)'" />

                <x-admin.button type="button" variant="secondary" wire:click="closeView">Close</x-admin.button>
            </div>
        @endif
    </x-admin.modal>
</div>
