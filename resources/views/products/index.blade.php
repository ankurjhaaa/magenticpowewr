@extends('layouts.public')

@section('title', 'Batteries & Solutions — Magnetic EV')
@section('meta_description', 'Explore Magnetic EV battery solutions for electric scooters, e-rickshaws, and energy storage.')

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
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                
                {{-- Pagination Links --}}
                <div class="mt-16">
                    {{ $products->links() }}
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
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['support_whatsapp'] ?? '919876543210') }}?text={{ urlencode('Hi, I am looking for custom battery engineering.') }}" 
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-3 bg-brand-500 text-black px-12 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-[#25D366] transition-colors duration-300 rounded-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    Chat on WhatsApp
                </a>
            </div>
        </div>
    </section>

@endsection
