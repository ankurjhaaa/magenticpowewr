@extends('layouts.public')

@section('title', 'Batteries & Solutions — Magnatic EV')
@section('meta_description', 'Explore Magnatic EV battery solutions for electric scooters, e-rickshaws, and energy storage.')

@section('content')

    {{-- Custom Cursor --}}
    <div class="custom-cursor" id="custom-cursor">
        <span class="custom-cursor-text" id="cursor-text"></span>
    </div>

    {{-- ============================================================
         HERO SECTION (Cinematic Header)
         ============================================================ --}}
    <section class="relative pt-32 pb-20 md:pt-48 md:pb-28 bg-black overflow-hidden">
        {{-- Subtle background glow --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[80vw] h-[40vh] bg-brand-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 text-center">
            <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-4 fade-up">Our Solutions</p>
            <h1 class="text-4xl md:text-6xl lg:text-[5rem] font-black text-white tracking-tighter leading-[0.95] mb-6 fade-up">
                POWERING EVERY <br><span class="text-brand-500">APPLICATION.</span>
            </h1>
            <p class="text-white/40 text-sm md:text-base leading-relaxed max-w-2xl mx-auto fade-up">
                From high-speed electric motorcycles to heavy-duty commercial rickshaws, we engineer lithium-ion battery packs that deliver uncompromising performance, safety, and longevity.
            </p>
        </div>
    </section>

    {{-- ============================================================
         CATEGORY FILTER / TABS
         ============================================================ --}}
    <section class="bg-black border-y border-white/5 sticky top-[5rem] lg:top-[6rem] z-40 backdrop-blur-md bg-black/80">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex overflow-x-auto hide-scrollbar py-4 gap-6 items-center">
                <a href="{{ route('products') }}" class="whitespace-nowrap text-xs font-bold uppercase tracking-widest {{ !request('category') ? 'text-brand-500' : 'text-white/40 hover:text-white transition-colors' }}">
                    All Batteries
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('products', ['category' => $category->slug]) }}" class="whitespace-nowrap text-xs font-bold uppercase tracking-widest {{ request('category') === $category->slug ? 'text-brand-500' : 'text-white/40 hover:text-white transition-colors' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         PRODUCTS GRID
         ============================================================ --}}
    <section class="py-20 md:py-32 bg-black relative z-10 min-h-[50vh] cursor-product-zone">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            
            @if($products->isEmpty())
                <div class="text-center py-20 border border-white/5 bg-carbon-800/20 rounded-xl">
                    <svg class="w-16 h-16 text-white/10 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <h3 class="text-xl font-bold text-white mb-2">No products found.</h3>
                    <p class="text-white/30 text-sm">We couldn't find any products in this category.</p>
                    <a href="{{ route('products') }}" class="inline-block mt-6 px-8 py-3 bg-white/5 hover:bg-white/10 text-white text-xs font-bold uppercase tracking-widest transition-colors rounded-full border border-white/10">Clear Filter</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($products as $product)
                        <div class="bg-carbon-800/30 border border-white/5 hover:border-brand-500/40 transition-all duration-500 group fade-up relative overflow-hidden flex flex-col h-full">
                            
                            {{-- Hover Glow --}}
                            <div class="absolute top-0 right-0 w-48 h-48 bg-brand-500/5 rounded-full blur-[60px] group-hover:bg-brand-500/15 transition-all duration-700 pointer-events-none"></div>
                            
                            {{-- Image Container --}}
                            <div class="aspect-[4/3] bg-black/40 flex items-center justify-center border-b border-white/5 overflow-hidden relative p-8">
                                @if($product->images->count() > 0)
                                    <img src="{{ Storage::url($product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <svg class="w-16 h-16 text-white/10 group-hover:scale-110 transition-transform duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <span class="absolute bottom-4 right-4 text-white/10 font-mono text-[10px]">RENDER PENDING</span>
                                @endif
                                
                                {{-- Quick tags --}}
                                @if($product->category)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-brand-500/10 border border-brand-500/20 text-brand-500 text-[9px] font-bold uppercase tracking-widest px-3 py-1 rounded-full backdrop-blur-sm">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-8 flex flex-col flex-grow">
                                <h3 class="text-2xl font-black text-white mb-3 group-hover:text-brand-500 transition-colors leading-tight">{{ $product->name }}</h3>
                                <p class="text-white/40 text-sm leading-relaxed mb-8 flex-grow">{{ $product->short_description }}</p>
                                
                                <div class="mt-auto flex items-center justify-between pt-6 border-t border-white/5">
                                    <span class="text-white/20 font-mono text-[10px] uppercase">Ref: {{ $product->slug }}</span>
                                    <a href="/contact" class="text-brand-500 text-[10px] font-bold uppercase tracking-widest hover:text-white transition-colors flex items-center gap-2">
                                        Inquire Now <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============================================================
         SCENE — CUSTOM SOLUTIONS CTA
         ============================================================ --}}
    <section class="py-24 md:py-32 bg-black border-t border-white/5 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 lg:px-12 text-center relative z-10">
            <h2 class="text-2xl md:text-4xl font-black text-white tracking-tighter mb-4 fade-up">NEED A CUSTOM BATTERY ARCHITECTURE?</h2>
            <p class="text-white/40 text-sm md:text-base leading-relaxed mb-10 fade-up">
                Our in-house R&D team can engineer bespoke lithium-ion packs tailored specifically to your vehicle's payload, spatial constraints, and discharge requirements.
            </p>
            <div class="fade-up">
                <a href="/contact" class="inline-flex items-center justify-center bg-transparent hover:bg-white/5 border border-brand-500/40 text-brand-500 hover:text-brand-400 px-8 py-4 rounded-full text-[11px] font-bold uppercase tracking-widest transition-all">
                    Request Custom Engineering <span class="ml-2">&rarr;</span>
                </a>
            </div>
        </div>
    </section>

@endsection
