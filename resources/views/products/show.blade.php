@extends('layouts.public')

@section('title', $product->name . ' — Magnatic EV')
@section('meta_description', $product->short_description)

@section('header_left')
    <a href="{{ route('products') }}" class="text-white hover:text-brand-500 transition-colors flex items-center gap-3 group">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="square" stroke-linejoin="miter" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        <span class="hidden sm:block text-[9px] uppercase tracking-widest font-bold group-hover:text-white transition-colors">Back</span>
    </a>
@endsection

@section('content')

    {{-- PRODUCT VIEW --}}
    {{-- Add pb-32 on mobile for the fixed bottom action bar, normal padding on desktop --}}
    <section class="w-full bg-black relative pt-20 border-b border-white/5 pb-32 lg:pb-16">
        
        {{-- Background Typography --}}
        <div class="absolute inset-0 flex items-start justify-center z-0 opacity-[0.03] pointer-events-none select-none overflow-hidden pt-20">
            <h1 class="text-[25vw] font-black text-white whitespace-nowrap">{{ Str::limit($product->name, 5, '') }}</h1>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 pt-4 lg:pt-12">
            
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
                
                {{-- 1. LEFT/TOP: Main Image Gallery (Sticky on Desktop) --}}
                <div class="w-full lg:w-1/2 flex flex-col lg:sticky lg:top-32 h-fit">
                    <div class="w-full aspect-square bg-white/[0.01] border border-white/5 mb-6 flex items-center justify-center p-6 lg:p-12 fade-up group">
                        @if($product->images->count() > 0)
                            <img id="main-product-image" src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="text-white/10 font-mono text-xl uppercase tracking-widest">No Image</div>
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    @if($product->images->count() > 1)
                        <div class="flex gap-3 justify-center mb-10 lg:mb-0 fade-up">
                            @foreach($product->images as $image)
                                <div class="w-16 h-16 border border-white/10 bg-white/[0.05] p-2 hover:border-brand-500 cursor-pointer transition-colors"
                                     onclick="changeMainImage('{{ Storage::url($image->image_path) }}')">
                                    <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-contain">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Add Image Change Script --}}
                <script>
                    function changeMainImage(src) {
                        const mainImage = document.getElementById('main-product-image');
                        if(mainImage) {
                            // Add a subtle fade effect during change
                            mainImage.style.opacity = 0;
                            setTimeout(() => {
                                mainImage.src = src;
                                mainImage.style.opacity = 1;
                            }, 150);
                        }
                    }
                </script>

                {{-- 2. RIGHT/BOTTOM: Product Info & Details --}}
                <div class="w-full lg:w-1/2 flex flex-col fade-up pb-8 lg:pb-0">
                    
                    {{-- Title & Core Details --}}
                    <div class="text-center lg:text-left mb-10">
                        @if($product->category)
                            <p class="text-brand-500 text-[9px] font-bold uppercase tracking-[0.3em] mb-3">{{ $product->category->name }}</p>
                        @endif
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter uppercase mb-6 leading-none">{{ $product->name }}</h2>
                        
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 mb-8">
                            <span class="bg-white/5 px-3 py-1.5 text-[9px] font-mono text-white/50 uppercase tracking-widest">SKU: {{ $product->sku ?? $product->slug }}</span>
                            @if($product->is_featured)
                                <span class="bg-brand-500/10 text-brand-500 px-3 py-1.5 text-[9px] font-bold uppercase tracking-widest border border-brand-500/20">Featured</span>
                            @endif
                        </div>

                        <p class="text-white/40 text-sm leading-relaxed max-w-2xl mx-auto lg:mx-0 mb-12">
                            {{ $product->description ?? $product->short_description }}
                        </p>
                    </div>

                    {{-- Specs & Variants --}}
                    <div class="flex flex-col gap-10 mb-8">
                        
                        {{-- Specs --}}
                        <div>
                            <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4 text-center lg:text-left">Tech Specs</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                                    <span class="block text-white/30 text-[8px] uppercase tracking-widest mb-1">Voltage</span>
                                    <span class="text-white font-bold text-xs">48V - 72V</span>
                                </div>
                                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                                    <span class="block text-white/30 text-[8px] uppercase tracking-widest mb-1">Capacity</span>
                                    <span class="text-white font-bold text-xs">30Ah - 100Ah</span>
                                </div>
                                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                                    <span class="block text-white/30 text-[8px] uppercase tracking-widest mb-1">Cycle Life</span>
                                    <span class="text-white font-bold text-xs">2000+</span>
                                </div>
                                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                                    <span class="block text-white/30 text-[8px] uppercase tracking-widest mb-1">Protection</span>
                                    <span class="text-white font-bold text-xs">IP67</span>
                                </div>
                            </div>
                        </div>

                        {{-- Variants --}}
                        @if($product->variants && $product->variants->count() > 0)
                            <div>
                                <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4 text-center lg:text-left">Configurations</h3>
                                <div class="flex flex-col gap-2">
                                    @foreach($product->variants as $variant)
                                        <div class="border border-white/5 bg-white/[0.01] p-4 flex items-center justify-between hover:border-brand-500/50 transition-colors group cursor-pointer">
                                            <div>
                                                <span class="block text-white font-bold uppercase tracking-widest text-xs">{{ $variant->name }}</span>
                                                <span class="block text-white/40 text-[9px] font-mono mt-0.5">SKU: {{ $variant->sku }}</span>
                                            </div>
                                            <div class="text-right">
                                                @if($variant->price)
                                                    <span class="block text-brand-500 font-bold text-sm">₹{{ number_format($variant->price, 2) }}</span>
                                                @else
                                                    <span class="block text-brand-500 font-bold uppercase text-[9px] tracking-widest">On Request</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Desktop CTA (Hidden on Mobile) --}}
                    <div class="hidden lg:flex flex-row gap-4 mt-8 pt-8 border-t border-white/5">
                        <a href="/contact" class="flex-1 bg-brand-500 text-black px-6 py-4 text-[11px] font-bold uppercase tracking-widest hover:bg-brand-400 transition-colors text-center rounded-none flex items-center justify-center gap-2 group">
                            Request Quote <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                        <a href="/technology" class="flex-1 border border-white/20 text-white px-6 py-4 text-[11px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors text-center rounded-none flex items-center justify-center">
                            Tech Specs
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- MOBILE FIXED BOTTOM CTA BAR (Hidden on Desktop) --}}
    <div class="fixed bottom-0 inset-x-0 z-40 bg-black/90 backdrop-blur-xl border-t border-white/10 p-4 shadow-[0_-10px_40px_rgba(0,0,0,0.5)] lg:hidden">
        <div class="flex flex-row gap-3">
            <a href="/contact" class="flex-1 bg-brand-500 text-black px-4 py-3.5 text-[10px] font-bold uppercase tracking-widest hover:bg-brand-400 transition-colors text-center rounded-none flex items-center justify-center gap-2 group">
                Request Quote <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
            </a>
            <a href="/technology" class="flex-1 border border-white/20 text-white px-4 py-3.5 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors text-center rounded-none flex items-center justify-center">
                Tech Specs
            </a>
        </div>
    </div>

    {{-- RELATED PRODUCTS --}}
    @if($relatedProducts->count() > 0)
    <section class="py-24 bg-black">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <h3 class="text-2xl font-black text-white uppercase mb-12 tracking-tighter">Related Solutions</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedProducts as $related)
                    <div class="bg-black border border-white/5 hover:border-white/20 transition-all duration-300 group relative flex flex-col rounded-none">
                        <a href="{{ route('products.show', $related->slug) }}" class="absolute inset-0 z-20"></a>
                        <div class="h-48 bg-white/[0.02] flex items-center justify-center border-b border-white/5 p-4">
                            @if($related->images->count() > 0)
                                <img src="{{ Storage::url($related->images->first()->image_path) }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="text-lg font-black text-white uppercase mb-2 group-hover:text-brand-500 transition-colors">{{ $related->name }}</h4>
                            <span class="text-brand-500 text-[9px] font-bold uppercase tracking-widest">View Details &rarr;</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection
