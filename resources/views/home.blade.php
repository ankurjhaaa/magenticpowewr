@extends('layouts.public')

@section('content')

        {{-- ============================================================
         SCENE 01 — HERO
         ============================================================ --}}
    <section id="scene-hero" class="scene-container bg-black relative">
        <div class="absolute inset-0 z-0">
            <img src="/images/banners.png" class="w-full h-full object-cover" id="hero-battery-img" alt="Magnatic EV">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <div class="relative z-10 w-full max-w-6xl mx-auto px-6 lg:px-12 text-center flex flex-col items-center justify-center" id="hero-text-block">
            <p class="text-brand-500 text-[11px] font-bold uppercase tracking-[0.4em] mb-6 fade-up">magnaticev.com</p>
            <h1 class="text-[11vw] sm:text-6xl md:text-7xl lg:text-[6.5rem] font-black text-white tracking-tighter leading-[0.95] fade-up">
                POWERING<br>THE NEXT <span class="text-brand-500">RIDE</span>
            </h1>
            <p class="mt-6 md:mt-8 text-sm md:text-base text-white/50 font-light max-w-lg mx-auto leading-relaxed fade-up">
                Advanced Lithium-Ion Batteries for Electric Mobility. Engineered for longer range, faster charging, and dependable performance.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 fade-up">
                <div class="magnetic-trigger p-1"><a href="#products-section" class="magnetic-btn btn-solid">Explore Batteries</a></div>
                <div class="magnetic-trigger p-1"><a href="#tech-section" class="magnetic-btn btn-cinematic">Discover Technology <span class="arrow">&rarr;</span></a></div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center z-30 pointer-events-none">
            <span class="text-[10px] text-white/30 uppercase tracking-[0.3em] font-semibold mb-3">Scroll</span>
            <div class="w-px h-10 bg-white/10 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-full bg-brand-500 animate-[scrollDown_2s_ease-in-out_infinite]"></div>
            </div>
        </div>
    </section>    {{-- ============================================================
         THE RIDE (Driving Simulator)
         ============================================================ --}}
    <div id="range-sequence-wrapper" class="relative bg-black border-t border-white/5" style="height: 300vh;">
        <section class="sticky top-0 w-full h-screen overflow-hidden flex flex-col items-center justify-center bg-black">
            <div class="absolute top-20 md:top-24 z-20 text-center px-4">
                <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-2 fade-up">Performance</p>
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter fade-up">GO FARTHER.</h2>
            </div>

            {{-- Road --}}
            <div class="absolute bottom-0 left-0 right-0 h-[50vh] overflow-hidden z-[1]" style="perspective: 500px;">
                <div class="absolute inset-0 bg-carbon-800" style="transform: rotateX(50deg); transform-origin: bottom center;">
                    <div class="absolute left-1/2 -translate-x-1/2 top-0 w-[3px] h-[200%]" id="road-dashes" style="background: repeating-linear-gradient(to bottom, #ccff00 0px, #ccff00 30px, transparent 30px, transparent 100px);"></div>
                    <div class="absolute left-[8%] top-0 w-px h-full bg-white/10"></div>
                    <div class="absolute right-[8%] top-0 w-px h-full bg-white/10"></div>
                </div>
            </div>

            {{-- Scooter --}}
            <div class="absolute bottom-[26vh] left-1/2 -translate-x-1/2 z-10" id="scooter-rider">
                <svg viewBox="0 0 100 60" class="w-20 md:w-28 text-white/70" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="20" cy="48" r="10"/><circle cx="20" cy="48" r="3" fill="currentColor"/>
                    <circle cx="80" cy="48" r="10"/><circle cx="80" cy="48" r="3" fill="currentColor"/>
                    <path d="M20 48 L30 28 L65 24 L80 48"/><path d="M65 24 L70 10 L76 10" stroke-linecap="round"/>
                    <path d="M33 27 L58 23" stroke-width="2.5" stroke-linecap="round"/>
                    <rect x="38" y="30" width="20" height="10" rx="2" class="text-brand-500" stroke-width="1"/>
                </svg>
                <div class="w-12 h-1.5 bg-brand-500/30 blur-sm rounded-full mx-auto mt-1" id="scooter-glow"></div>
            </div>

            {{-- HUD --}}
            <div class="absolute bottom-8 md:bottom-14 z-20 flex flex-col items-center w-full px-6">
                <div class="flex items-baseline gap-1 mb-3">
                    <span class="text-4xl md:text-[5rem] font-black text-white leading-none tracking-tighter tabular-nums" id="speed-display">0</span>
                    <span class="text-xs md:text-base text-brand-500 font-bold tracking-widest">KM/H</span>
                </div>
                <div class="flex items-center gap-6 mb-3">
                    <div class="text-center">
                        <p class="text-white/20 text-[8px] uppercase tracking-widest">Distance</p>
                        <span class="text-lg md:text-2xl font-black text-white tabular-nums" id="distance-number">0</span><span class="text-[9px] text-brand-500 font-bold ml-1">KM</span>
                    </div>
                    <div class="w-px h-6 bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-white/20 text-[8px] uppercase tracking-widest">Battery</p>
                        <span class="text-lg md:text-2xl font-black text-white tabular-nums" id="battery-percent">100</span><span class="text-[9px] text-brand-500 font-bold ml-1">%</span>
                    </div>
                </div>
                <div class="w-48 md:w-64 h-1.5 bg-white/5 rounded-full overflow-hidden border border-white/10">
                    <div class="h-full bg-brand-500 rounded-full shadow-[0_0_6px_#ccff00]" id="battery-indicator" style="width:100%;"></div>
                </div>
            </div>
        </section>
    </div>

    <div id="products-section" class="relative z-20 bg-black">
        @foreach($products as $product)
        <section class="sticky top-0 h-[100svh] w-full flex items-center bg-black overflow-hidden border-t border-white/5">
            
            <div class="w-full max-w-7xl mx-auto px-6 lg:px-12 flex flex-col-reverse md:flex-row items-center justify-between gap-8 md:gap-16 relative z-10 h-full py-16 md:py-0">
                
                {{-- Text Content --}}
                <div class="w-full md:w-1/2 flex flex-col justify-center text-center md:text-left h-1/2 md:h-full pb-8 md:pb-0">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                        <span class="text-brand-500 font-black text-xl md:text-2xl">0{{ $loop->iteration }}</span>
                        <div class="h-px w-8 bg-brand-500/50"></div>
                        @if($product->category)
                            <p class="text-white/50 text-[10px] font-bold uppercase tracking-[0.4em]">{{ $product->category->name }}</p>
                        @endif
                    </div>
                    
                    <h3 class="text-3xl md:text-4xl lg:text-5xl font-black text-white tracking-tighter mb-4 uppercase">{{ $product->name }}</h3>
                    <p class="text-white/40 text-sm leading-relaxed max-w-md mx-auto md:mx-0 mb-6">{{ $product->short_description }}</p>
                    
                    {{-- Specs Grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-8 max-w-md mx-auto md:mx-0">
                        <div class="border border-white/5 bg-white/[0.02] p-3 text-left">
                            <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Voltage</span>
                            <span class="text-white font-bold text-sm">48V - 72V</span>
                        </div>
                        <div class="border border-white/5 bg-white/[0.02] p-3 text-left">
                            <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Capacity</span>
                            <span class="text-white font-bold text-sm">30Ah - 50Ah</span>
                        </div>
                        <div class="border border-white/5 bg-white/[0.02] p-3 text-left">
                            <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Cycle Life</span>
                            <span class="text-white font-bold text-sm">2000+ Cycles</span>
                        </div>
                        <div class="border border-white/5 bg-white/[0.02] p-3 text-left">
                            <span class="block text-white/30 text-[9px] uppercase tracking-widest mb-1">Protection</span>
                            <span class="text-white font-bold text-sm">IP67 Rated</span>
                        </div>
                    </div>
                    
                    <div>
                        <a href="#" class="border border-white/20 text-white px-8 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-white hover:text-black transition-colors duration-300 rounded-none inline-block">Explore Details</a>
                    </div>
                </div>

                {{-- Image Content --}}
                <div class="w-full md:w-1/2 h-[45%] md:h-[80%] flex items-center justify-center relative pt-8 md:pt-0">
                    {{-- Typography Background Behind Image --}}
                    <div class="absolute inset-0 flex items-center justify-center z-0 opacity-5 pointer-events-none select-none">
                        <h2 class="text-[25vw] md:text-[12vw] font-black text-white whitespace-nowrap">{{ Str::limit($product->name, 8, '') }}</h2>
                    </div>

                    @if($product->images->count() > 0)
                        <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-[85%] h-[85%] object-contain relative z-10 drop-shadow-[0_20px_50px_rgba(0,0,0,0.8)]">
                    @else
                        <div class="text-white/10 uppercase tracking-[0.4em] text-[10px] font-bold relative z-10">No Image Available</div>
                    @endif
                </div>
                
            </div>
        </section>
        @endforeach

        {{-- See More CTA --}}
        <section class="h-[40vh] w-full flex flex-col items-center justify-center bg-black border-t border-white/5 relative z-10 text-center px-6">
            <h3 class="text-2xl md:text-4xl font-black text-white mb-6 tracking-tighter">DISCOVER THE FULL RANGE</h3>
            <a href="/products" class="bg-brand-500 text-black px-8 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-brand-400 transition-colors duration-300 rounded-none inline-block">See All Products &rarr;</a>
        </section>
    </div>

@endsection
