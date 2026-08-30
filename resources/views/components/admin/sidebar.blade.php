<div class="flex flex-col h-full">
    <div class="h-16 flex items-center gap-2 px-4 border-b border-gray-200 shrink-0">
        @if ($logo = \App\Models\Setting::get('site_logo'))
            <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" class="w-8 h-8 rounded-lg object-cover">
        @else
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-900 text-white font-bold text-xs">MP</span>
        @endif
        <span class="font-semibold text-gray-900 text-sm leading-tight">Magnetic Power<br>Battery</span>
    </div>

    <nav class="thin-scrollbar flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <x-admin.nav-link route-name="admin.dashboard">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/>
                    <rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/>
                    <rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/>
                    <rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/>
                </svg>
            </x-slot:icon>
            Dashboard
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.categories.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h8l8 8-8 8-8-8V4z"/>
                    <circle cx="8" cy="8" r="1.25" fill="currentColor" stroke="none"/>
                </svg>
            </x-slot:icon>
            Categories
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.brands.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 3h12v18l-6-4-6 4V3z"/>
                </svg>
            </x-slot:icon>
            Brands
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.products.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"/>
                    <path d="M12 12v9M12 12l8-4.5M12 12L4 7.5"/>
                </svg>
            </x-slot:icon>
            Products
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.applications.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L4 14h6l-1 8 9-12h-6l1-8z"/>
                </svg>
            </x-slot:icon>
            Applications
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.specifications.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 3H6a1 1 0 00-1 1v16a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1h-3"/>
                    <path d="M9 3a1.5 1.5 0 013-.001V3a1.5 1.5 0 013 0v1.5a1 1 0 01-1 1H10a1 1 0 01-1-1V3z"/>
                    <path d="M8 12h8M8 16h5"/>
                </svg>
            </x-slot:icon>
            Specifications
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.inquiries.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16v12H8l-4 4V4z"/>
                </svg>
            </x-slot:icon>
            Product Enquiries
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.contact-messages.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path d="M3 7l9 6 9-6"/>
                </svg>
            </x-slot:icon>
            Contact Messages
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.banners.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 3v18"/>
                    <path d="M5 4h13l-3 4 3 4H5"/>
                </svg>
            </x-slot:icon>
            Banners
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.faqs.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M9.5 9.5a2.5 2.5 0 114 2c-.6.5-1.5 1-1.5 2.2"/>
                    <circle cx="12" cy="17" r=".6" fill="currentColor" stroke="none"/>
                </svg>
            </x-slot:icon>
            FAQs
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.team-members.index">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="8" r="3"/>
                    <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
                    <circle cx="17" cy="9" r="2.3"/>
                    <path d="M15.2 14.3c2.1.4 3.8 2.4 3.8 5.7"/>
                </svg>
            </x-slot:icon>
            Team Members
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.company-profile.edit">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="4" y="3" width="10" height="18"/>
                    <rect x="14" y="9" width="6" height="12"/>
                    <path d="M7 7h1M11 7h1M7 11h1M11 11h1M7 15h1M11 15h1M17 12h1M17 16h1"/>
                </svg>
            </x-slot:icon>
            Company Profile
        </x-admin.nav-link>

        <x-admin.nav-link route-name="admin.settings.edit">
            <x-slot:icon>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M12 2v3M12 19v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M2 12h3M19 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1"/>
                </svg>
            </x-slot:icon>
            Settings
        </x-admin.nav-link>
    </nav>

    <div class="border-t border-gray-200 p-3 shrink-0">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-gray-900 hover:bg-gray-50 cursor-pointer">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                    <path d="M16 17l5-5-5-5"/>
                    <path d="M21 12H9"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>
