@props(['product'])
<div class="bg-black border border-white/5 hover:border-white/20 transition-all duration-300 group fade-up relative flex flex-col h-full rounded-none">
    
    {{-- Image Container --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block h-64 bg-white/[0.02] flex items-center justify-center border-b border-white/5 overflow-hidden relative p-8 cursor-pointer">
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
    </a>

    {{-- Content --}}
    <div class="p-8 flex flex-col flex-grow">
        <a href="{{ route('products.show', $product->slug) }}" class="block group-hover:text-brand-500 transition-colors">
            <h3 class="text-2xl font-black text-white mb-4 uppercase leading-tight">{{ $product->name }}</h3>
        </a>
        <p class="text-white/40 text-sm leading-relaxed mb-8 flex-grow">{{ $product->short_description }}</p>
        
        <div class="mt-auto pt-6 border-t border-white/5">
            <a href="{{ route('products.show', $product->slug) }}" class="text-white text-[10px] font-bold uppercase tracking-widest hover:text-brand-500 transition-colors flex items-center justify-between w-full">
                <span>View Details</span> <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
            </a>
        </div>
    </div>
</div>
