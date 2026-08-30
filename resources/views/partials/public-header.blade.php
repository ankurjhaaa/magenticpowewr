<header class="sticky top-0 z-50 bg-neutral-950/95 backdrop-blur border-b border-neutral-800">
    <input type="checkbox" id="mobile-nav-toggle" class="peer hidden">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="/" class="flex items-center gap-2 shrink-0">
                @if ($logo = \App\Models\Setting::get('site_logo'))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" class="h-9 w-auto">
                @else
                    <span class="text-lg font-bold tracking-tight text-white">Magnetic <span class="text-lime-400">Power</span></span>
                @endif
            </a>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="/" class="text-sm font-medium text-neutral-300 hover:text-lime-400 transition">Home</a>
                <a href="/products" class="text-sm font-medium text-neutral-300 hover:text-lime-400 transition">Products</a>
                <a href="/about" class="text-sm font-medium text-neutral-300 hover:text-lime-400 transition">About</a>
                <a href="/contact" class="text-sm font-medium text-neutral-300 hover:text-lime-400 transition">Contact</a>
                <a href="/faqs" class="text-sm font-medium text-neutral-300 hover:text-lime-400 transition">FAQs</a>
            </nav>

            <div class="hidden lg:block shrink-0">
                <a href="/contact" class="inline-flex items-center rounded-lg bg-lime-400 px-5 py-2.5 text-sm font-semibold text-neutral-950 hover:bg-lime-300 transition">
                    Get a Quote
                </a>
            </div>

            <label for="mobile-nav-toggle" class="lg:hidden cursor-pointer text-neutral-200 p-2 -mr-2 block">
                <svg class="w-6 h-6 peer-checked:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="w-6 h-6 hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </label>
        </div>
    </div>

    {{-- Mobile nav panel (CSS-only toggle, no JS) --}}
    <div class="hidden peer-checked:block lg:hidden border-t border-neutral-800 bg-neutral-950 px-4 py-4 space-y-1">
        <a href="/" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-neutral-200 hover:bg-neutral-900 hover:text-lime-400 transition">Home</a>
        <a href="/products" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-neutral-200 hover:bg-neutral-900 hover:text-lime-400 transition">Products</a>
        <a href="/about" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-neutral-200 hover:bg-neutral-900 hover:text-lime-400 transition">About</a>
        <a href="/contact" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-neutral-200 hover:bg-neutral-900 hover:text-lime-400 transition">Contact</a>
        <a href="/faqs" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-neutral-200 hover:bg-neutral-900 hover:text-lime-400 transition">FAQs</a>
        <a href="/contact" class="mt-2 flex items-center justify-center rounded-lg bg-lime-400 px-5 py-2.5 text-sm font-semibold text-neutral-950">
            Get a Quote
        </a>
    </div>
</header>
