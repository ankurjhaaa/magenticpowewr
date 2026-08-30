@php
    $footerCompany = \App\Models\CompanyProfile::query()->first();
    $footerCategories = \App\Models\Category::active()->ordered()->limit(5)->get();
@endphp

<footer class="bg-neutral-950 border-t border-neutral-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <span class="text-lg font-bold tracking-tight text-white">Magnetic <span class="text-lime-400">Power</span></span>
                <p class="mt-3 text-sm text-neutral-400 leading-relaxed">
                    {{ $footerCompany?->tagline ?? 'Powering Electric Mobility. Driving a Sustainable Future.' }}
                </p>

                <div class="mt-5 flex items-center gap-3">
                    @if ($url = \App\Models\Setting::get('facebook_url'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full border border-neutral-700 flex items-center justify-center text-neutral-300 hover:border-lime-400 hover:text-lime-400 transition text-xs font-semibold">f</a>
                    @endif
                    @if ($url = \App\Models\Setting::get('instagram_url'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full border border-neutral-700 flex items-center justify-center text-neutral-300 hover:border-lime-400 hover:text-lime-400 transition text-xs font-semibold">IG</a>
                    @endif
                    @if ($url = \App\Models\Setting::get('youtube_url'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full border border-neutral-700 flex items-center justify-center text-neutral-300 hover:border-lime-400 hover:text-lime-400 transition text-xs font-semibold">YT</a>
                    @endif
                    @if ($url = \App\Models\Setting::get('linkedin_url'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full border border-neutral-700 flex items-center justify-center text-neutral-300 hover:border-lime-400 hover:text-lime-400 transition text-xs font-semibold">in</a>
                    @endif
                    @if ($url = \App\Models\Setting::get('twitter_url'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full border border-neutral-700 flex items-center justify-center text-neutral-300 hover:border-lime-400 hover:text-lime-400 transition text-xs font-semibold">X</a>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h3>
                <ul class="space-y-2.5 text-sm text-neutral-400">
                    <li><a href="/" class="hover:text-lime-400 transition">Home</a></li>
                    <li><a href="/products" class="hover:text-lime-400 transition">Products</a></li>
                    <li><a href="/about" class="hover:text-lime-400 transition">About Us</a></li>
                    <li><a href="/faqs" class="hover:text-lime-400 transition">FAQs</a></li>
                    <li><a href="/contact" class="hover:text-lime-400 transition">Contact</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Categories</h3>
                <ul class="space-y-2.5 text-sm text-neutral-400">
                    @forelse ($footerCategories as $category)
                        <li><a href="/products?category={{ $category->slug }}" class="hover:text-lime-400 transition">{{ $category->name }}</a></li>
                    @empty
                        <li class="text-neutral-600">Coming soon</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</h3>
                <ul class="space-y-2.5 text-sm text-neutral-400">
                    @if ($phone = \App\Models\Setting::get('whatsapp_number'))
                        <li>{{ $phone }}</li>
                    @endif
                    @if ($email = \App\Models\Setting::get('contact_email'))
                        <li>{{ $email }}</li>
                    @endif
                    @if ($address = \App\Models\Setting::get('address'))
                        <li>{{ $address }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-neutral-800 text-center text-sm text-neutral-500">
            &copy; {{ date('Y') }} {{ $footerCompany?->company_name ?? 'Magnetic Power Battery' }}. All rights reserved.
        </div>
    </div>
</footer>
