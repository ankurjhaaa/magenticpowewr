@extends('layouts.public')

@section('title', ($company?->company_name ?? 'Magnetic Power Battery') . ' — Lithium-ion Battery Manufacturer')
@section('meta_description', $company?->tagline ?? 'Professional Lithium-ion Battery Manufacturer specializing in LFP and NMC battery technologies for electric mobility and energy storage.')

@section('content')

    {{-- Hero / Banners --}}
    @if ($banners->isNotEmpty())
        <section class="relative">
            <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth">
                @foreach ($banners as $banner)
                    <div class="relative w-full shrink-0 snap-center">
                        <div class="relative h-[420px] sm:h-[480px]">
                            <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/60 to-neutral-950/20"></div>
                            <div class="relative h-full mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col justify-end pb-16">
                                @if ($banner->title)
                                    <h1 class="text-3xl sm:text-5xl font-bold tracking-tight text-white max-w-2xl">{{ $banner->title }}</h1>
                                @endif
                                @if ($banner->subtitle)
                                    <p class="mt-4 max-w-xl text-neutral-300">{{ $banner->subtitle }}</p>
                                @endif
                                @if ($banner->button_text && $banner->button_url)
                                    <a href="{{ $banner->button_url }}" class="mt-6 inline-flex w-fit items-center rounded-lg bg-lime-400 px-6 py-3 text-sm font-semibold text-neutral-950 hover:bg-lime-300 transition">
                                        {{ $banner->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <section class="relative overflow-hidden border-b border-neutral-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24 sm:py-32 text-center">
                <h1 class="text-3xl sm:text-5xl font-bold tracking-tight text-white">
                    Powering Electric Mobility.<br>
                    <span class="text-lime-400">Driving a Sustainable Future.</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-neutral-400">
                    {{ $company?->about ?? 'Professional Lithium-ion Battery Manufacturer specializing in LFP and NMC battery technologies for electric mobility and energy storage.' }}
                </p>
                <div class="mt-8 flex items-center justify-center gap-4">
                    <a href="/products" class="inline-flex items-center rounded-lg bg-lime-400 px-6 py-3 text-sm font-semibold text-neutral-950 hover:bg-lime-300 transition">
                        Explore Products
                    </a>
                    <a href="/contact" class="inline-flex items-center rounded-lg border border-neutral-700 px-6 py-3 text-sm font-semibold text-neutral-200 hover:border-lime-400 hover:text-lime-400 transition">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Categories --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-sm font-semibold text-lime-400 uppercase tracking-wider">Explore</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-white mt-1">Battery Categories</h2>
            </div>
            <a href="/products" class="hidden sm:inline-flex text-sm font-medium text-neutral-400 hover:text-lime-400 transition">View all &rarr;</a>
        </div>

        @forelse ($categories as $category)
            @if ($loop->first)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @endif

            <a href="/products?category={{ $category->slug }}"
                class="group relative rounded-2xl border border-neutral-800 bg-neutral-900 overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:border-lime-400/50">
                <div class="h-40 bg-neutral-800 flex items-center justify-center overflow-hidden">
                    @if ($category->image)
                        <img src="{{ Storage::url($category->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <svg class="w-10 h-10 text-neutral-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 4h8l8 8-8 8-8-8V4z"/>
                        </svg>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-white font-semibold">{{ $category->name }}</h3>
                    <p class="text-sm text-neutral-500 mt-1">{{ $category->products_count }} products</p>
                </div>
            </a>

            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-12 text-center text-neutral-500">
                Categories coming soon.
            </div>
        @endforelse
    </section>

    {{-- Featured products --}}
    <section class="border-t border-neutral-800 bg-neutral-900/40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-sm font-semibold text-lime-400 uppercase tracking-wider">Our Range</p>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white mt-1">Featured Products</h2>
                </div>
                <a href="/products" class="hidden sm:inline-flex text-sm font-medium text-neutral-400 hover:text-lime-400 transition">View all &rarr;</a>
            </div>

            @forelse ($products as $product)
                @if ($loop->first)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @endif

                <a href="/products/{{ $product->slug }}"
                    class="group rounded-2xl border border-neutral-800 bg-neutral-950 overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:border-lime-400/50">
                    <div class="h-44 bg-neutral-800 flex items-center justify-center overflow-hidden">
                        @if ($product->images->first())
                            <img src="{{ Storage::url($product->images->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <svg class="w-10 h-10 text-neutral-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-neutral-500">{{ $product->category?->name }}</p>
                        <h3 class="text-white font-semibold mt-1">{{ $product->name }}</h3>
                        <p class="text-xs text-neutral-500 mt-1">{{ $product->brand?->name }}</p>
                    </div>
                </a>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="rounded-2xl border border-neutral-800 bg-neutral-950 p-12 text-center text-neutral-500">
                    Products coming soon.
                </div>
            @endforelse
        </div>
    </section>

    {{-- Company intro --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
                <p class="text-sm font-semibold text-lime-400 uppercase tracking-wider">Who We Are</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-white mt-1">{{ $company?->company_name ?? 'Magnetic Power Battery' }}</h2>
                <p class="mt-4 text-neutral-400 leading-relaxed">
                    {{ $company?->about ?? 'Magnetic Power Battery is a professional Lithium-ion Battery Manufacturer specializing in advanced LFP and NMC battery technologies.' }}
                </p>
                <a href="/about" class="mt-6 inline-flex items-center text-sm font-semibold text-lime-400 hover:text-lime-300 transition">
                    Learn more about us &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
                    <h3 class="text-white font-semibold mb-2">Our Vision</h3>
                    <p class="text-sm text-neutral-400 leading-relaxed">{{ $company?->vision ?? 'To become a trusted and innovative Lithium Battery Manufacturing Brand.' }}</p>
                </div>
                <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
                    <h3 class="text-white font-semibold mb-2">Our Mission</h3>
                    <p class="text-sm text-neutral-400 leading-relaxed">{{ $company?->mission ?? 'To manufacture safe, reliable and technologically advanced battery solutions.' }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="border-t border-neutral-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">Have a question about our batteries?</h2>
            <p class="mt-3 text-neutral-400">Get in touch with our team for pricing, specifications and dealership enquiries.</p>
            <a href="/contact" class="mt-6 inline-flex items-center rounded-lg bg-lime-400 px-6 py-3 text-sm font-semibold text-neutral-950 hover:bg-lime-300 transition">
                Contact Us
            </a>
        </div>
    </section>

@endsection
