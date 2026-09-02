@extends('layouts.public')

@section('title', $product->name . ' — Magnetic EV')
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
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['support_whatsapp'] ?? '919876543210') }}?text={{ urlencode('Hi, I want a quote for ' . $product->name) }}" target="_blank" rel="noopener noreferrer" class="flex-1 bg-brand-500 text-black px-6 py-4 text-[11px] font-bold uppercase tracking-widest hover:bg-[#25D366] transition-colors text-center rounded-none flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            WhatsApp
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
    <div class="fixed bottom-0 left-0 w-full max-w-[100vw] z-50 bg-black/95 backdrop-blur-xl border-t border-white/10 p-3 pb-safe lg:hidden shadow-[0_-10px_40px_rgba(0,0,0,0.5)]">
        <div class="flex flex-row gap-2 w-full">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['support_whatsapp'] ?? '919876543210') }}?text={{ urlencode('Hi, I want a quote for ' . $product->name) }}" target="_blank" rel="noopener noreferrer" class="flex-1 bg-brand-500 text-black py-3 px-2 text-[10px] font-bold uppercase tracking-widest hover:bg-[#25D366] transition-colors text-center rounded-none flex items-center justify-center gap-1.5 overflow-hidden">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                <span class="truncate">WhatsApp</span>
            </a>
            <a href="/technology" class="flex-1 border border-white/20 text-white py-3 px-2 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-colors text-center rounded-none flex items-center justify-center overflow-hidden">
                <span class="truncate">Tech Specs</span>
            </a>
        </div>
    </div>

    {{-- RELATED PRODUCTS --}}
    @if($relatedProducts->count() > 0)
    <section class="pt-8 pb-24 lg:pt-24 lg:pb-32 bg-black">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <h3 class="text-2xl font-black text-white uppercase mb-8 lg:mb-12 tracking-tighter">Related Solutions</h3>
            
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
