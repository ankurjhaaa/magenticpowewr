@extends('layouts.public')

@section('title', 'Batteries & Solutions — Magnatic EV')
@section('meta_description', 'Explore Magnatic EV battery solutions for electric scooters, e-rickshaws, and energy storage.')

@section('content')

    {{-- ============================================================
         CATEGORY FILTER / TABS
         ============================================================ --}}
    <section class="bg-black/90 backdrop-blur-md border-b border-white/5 sticky top-20 z-40 mt-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex overflow-x-auto hide-scrollbar py-6 gap-8 items-center">
                <a href="{{ route('products') }}" class="whitespace-nowrap text-[10px] font-bold uppercase tracking-widest {{ !request('category') ? 'text-brand-500' : 'text-white/40 hover:text-white transition-colors' }}">
                    All Batteries
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('products', ['category' => $category->slug]) }}" class="whitespace-nowrap text-[10px] font-bold uppercase tracking-widest {{ request('category') === $category->slug ? 'text-brand-500' : 'text-white/40 hover:text-white transition-colors' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
         PRODUCTS GRID
         ============================================================ --}}
    <section class="pt-8 pb-24 md:pt-12 md:pb-32 bg-black relative z-10 min-h-[50vh]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            
            @if($products->isEmpty())
                <div class="text-center py-20 border border-white/5 bg-white/[0.02]">
                    <h3 class="text-2xl font-black text-white uppercase mb-2">No Products Found</h3>
                    <p class="text-white/40 text-sm mb-6">We couldn't find any products matching this category.</p>
                    <a href="{{ route('products') }}" class="inline-block px-8 py-4 bg-brand-500 text-black text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-brand-400 transition-colors rounded-none">Clear Filter</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        <div class="bg-black border border-white/5 hover:border-white/20 transition-all duration-300 group fade-up relative flex flex-col h-full rounded-none">
                            
                            {{-- Image Container --}}
                            <div class="h-64 bg-white/[0.02] flex items-center justify-center border-b border-white/5 overflow-hidden relative p-8">
                                {{-- Background Type --}}
                                <div class="absolute inset-0 flex items-center justify-center z-0 opacity-[0.03] pointer-events-none select-none">
                                    <span class="text-7xl font-black text-white whitespace-nowrap">{{ Str::limit($product->name, 5, '') }}</span>
                                </div>
                                
                                @if($product->images->count() > 0)
                                    <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain relative z-10 group-hover:scale-105 transition-transform duration-700 drop-shadow-xl">
                                @else
                                    <span class="absolute bottom-4 right-4 text-white/10 font-mono text-[10px] z-10">NO IMAGE</span>
                                @endif
                                
                                {{-- Quick tags --}}
                                @if($product->category)
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="bg-black border border-brand-500/30 text-brand-500 text-[9px] font-bold uppercase tracking-widest px-3 py-1 rounded-none">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-8 flex flex-col flex-grow">
                                <h3 class="text-2xl font-black text-white mb-4 uppercase leading-tight">{{ $product->name }}</h3>
                                <p class="text-white/40 text-sm leading-relaxed mb-8 flex-grow">{{ $product->short_description }}</p>
                                
                                <div class="mt-auto flex items-center justify-between pt-6 border-t border-white/5">
                                    <span class="text-white/20 font-mono text-[10px] uppercase">Ref: {{ $product->slug }}</span>
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-white text-[10px] font-bold uppercase tracking-widest hover:text-brand-500 transition-colors flex items-center gap-2">
                                        View Details <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
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
            <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter mb-6 uppercase fade-up">Need a Custom Architecture?</h2>
            <p class="text-white/40 text-sm md:text-base leading-relaxed mb-10 fade-up">
                Our in-house R&D team can engineer bespoke lithium-ion packs tailored specifically to your vehicle's payload, spatial constraints, and discharge requirements.
            </p>
            <div class="fade-up">
                <a href="/contact" class="inline-flex items-center justify-center bg-brand-500 text-black px-12 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-brand-400 transition-colors duration-300 rounded-none">
                    Request Custom Engineering
                </a>
            </div>
        </div>
    </section>

@endsection
