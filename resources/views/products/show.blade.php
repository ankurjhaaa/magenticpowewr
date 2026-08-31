@extends('layouts.public')

@section('title', $product->name . ' — Magnatic EV')
@section('meta_description', $product->short_description)

@section('content')

    {{-- HERO / PRODUCT OVERVIEW --}}
    <section class="min-h-screen w-full bg-black relative flex flex-col md:flex-row pt-20 border-b border-white/5">
        
        {{-- Background Typography --}}
        <div class="absolute inset-0 flex items-center justify-center z-0 opacity-[0.03] pointer-events-none select-none overflow-hidden">
            <h1 class="text-[30vw] font-black text-white whitespace-nowrap">{{ Str::limit($product->name, 5, '') }}</h1>
        </div>
        
        {{-- Left: Details --}}
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center relative z-10 fade-up border-b md:border-b-0 md:border-r border-white/5">
            @if($product->category)
                <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-4">{{ $product->category->name }}</p>
            @endif
            
            <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase mb-6 leading-none">{{ $product->name }}</h2>
            
            <div class="flex items-center gap-4 mb-8">
                <span class="bg-white/5 px-4 py-2 text-[10px] font-mono text-white/50 uppercase tracking-widest">SKU: {{ $product->sku ?? $product->slug }}</span>
                @if($product->is_featured)
                    <span class="bg-brand-500/10 text-brand-500 px-4 py-2 text-[10px] font-bold uppercase tracking-widest border border-brand-500/20">Featured</span>
                @endif
            </div>

            <p class="text-white/40 text-sm md:text-base leading-relaxed max-w-xl mb-12">
                {{ $product->description ?? $product->short_description }}
            </p>

            {{-- Tech Specs Grid --}}
            <div class="grid grid-cols-2 gap-4 mb-12 max-w-lg">
                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                    <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Voltage</span>
                    <span class="text-white font-bold text-sm">48V - 72V</span>
                </div>
                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                    <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Capacity</span>
                    <span class="text-white font-bold text-sm">30Ah - 100Ah</span>
                </div>
                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                    <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Cycle Life</span>
                    <span class="text-white font-bold text-sm">2000+ Cycles</span>
                </div>
                <div class="border border-white/5 bg-white/[0.02] p-4 text-left">
                    <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Protection</span>
                    <span class="text-white font-bold text-sm">IP67 Rated</span>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/contact" class="bg-brand-500 text-black px-10 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-brand-400 transition-colors text-center rounded-none">
                    Request Quote
                </a>
                <a href="/technology" class="border border-white/20 text-white px-10 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-white hover:text-black transition-colors text-center rounded-none">
                    View Tech Specs
                </a>
            </div>
        </div>

        {{-- Right: Images --}}
        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center items-center relative z-10 bg-white/[0.01]">
            @if($product->images->count() > 0)
                <div class="relative w-full aspect-square md:aspect-auto md:h-full flex items-center justify-center fade-up group">
                    <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-4/5 h-4/5 object-contain drop-shadow-2xl transition-transform duration-700 group-hover:scale-105">
                </div>
                
                {{-- Thumbnails if more than 1 image --}}
                @if($product->images->count() > 1)
                    <div class="flex gap-4 mt-8 justify-center fade-up">
                        @foreach($product->images as $image)
                            <div class="w-20 h-20 border border-white/10 bg-white/[0.05] p-2 hover:border-brand-500 cursor-pointer transition-colors">
                                <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-contain">
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="text-white/10 font-mono text-2xl uppercase tracking-widest rotate-90">No Image</div>
            @endif
        </div>
    </section>

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
