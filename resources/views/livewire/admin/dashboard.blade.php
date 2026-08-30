<div class="space-y-8">
    <div>
        <h1 class="text-xl font-semibold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-300 rounded-xl p-5 flex items-center gap-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"/>
                    <path d="M12 12v9M12 12l8-4.5M12 12L4 7.5"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['products'] }}</p>
                <p class="text-sm text-gray-500">Total Products</p>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-xl p-5 flex items-center gap-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <circle cx="9" cy="6" r="1.75"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <circle cx="15" cy="12" r="1.75"/>
                    <line x1="4" y1="18" x2="20" y2="18"/>
                    <circle cx="9" cy="18" r="1.75"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['variants'] }}</p>
                <p class="text-sm text-gray-500">Total Variants</p>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-xl p-5 flex items-center gap-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h8l8 8-8 8-8-8V4z"/>
                    <circle cx="8" cy="8" r="1.25" fill="currentColor" stroke="none"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['categories'] }}</p>
                <p class="text-sm text-gray-500">Total Categories</p>
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-xl p-5 flex items-center gap-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 3h12v18l-6-4-6 4V3z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['brands'] }}</p>
                <p class="text-sm text-gray-500">Total Brands</p>
            </div>
        </div>

        <a href="{{ route('admin.inquiries.index') }}" class="bg-white border border-gray-300 rounded-xl p-5 flex items-center gap-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-gray-400">
            <div class="relative w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16v12H8l-4 4V4z"/>
                </svg>
                @if ($stats['new_enquiries'] > 0)
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-rose-500 border-2 border-white"></span>
                @endif
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['new_enquiries'] }}</p>
                <p class="text-sm text-gray-500">New Enquiries</p>
            </div>
        </a>

        <a href="{{ route('admin.contact-messages.index') }}" class="bg-white border border-gray-300 rounded-xl p-5 flex items-center gap-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-gray-400">
            <div class="relative w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path d="M3 7l9 6 9-6"/>
                </svg>
                @if ($stats['unread_messages'] > 0)
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-sky-500 border-2 border-white"></span>
                @endif
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['unread_messages'] }}</p>
                <p class="text-sm text-gray-500">Unread Contact Messages</p>
            </div>
        </a>
    </div>

    {{-- Recent enquiries --}}
    <div class="bg-white border border-gray-300 rounded-xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Recent Enquiries</h2>
            <a href="{{ route('admin.inquiries.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                View all &rarr;
            </a>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse ($recentEnquiries as $enquiry)
                <div class="flex items-center justify-between gap-4 px-5 py-3.5">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $enquiry->name }}</p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $enquiry->variant?->name ?? $enquiry->variant_name_snapshot ?? '—' }}
                            &middot; {{ $enquiry->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                        {{ match($enquiry->status) {
                            'new' => 'bg-blue-50 text-blue-700 border border-blue-200',
                            'read' => 'bg-slate-50 text-slate-700 border border-slate-200',
                            'replied' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                            'closed' => 'bg-gray-50 text-gray-500 border border-gray-200',
                        } }}">
                        {{ ucfirst($enquiry->status) }}
                    </span>
                </div>
            @empty
                <p class="px-5 py-10 text-center text-sm text-gray-500">No enquiries yet.</p>
            @endforelse
        </div>
    </div>
</div>
