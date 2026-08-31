@extends('layouts.public')

@section('title', 'About Us — Magnatic EV')
@section('meta_description', 'Learn about Magnatic EV, our mission, vision, and the technology behind our advanced lithium-ion batteries.')

@section('content')

    {{-- HERO --}}
    <section class="h-[80vh] w-full bg-black relative flex items-center justify-center overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 flex items-center justify-center z-0 opacity-5 pointer-events-none select-none">
            <h1 class="text-[30vw] font-black text-white whitespace-nowrap">ABOUT</h1>
        </div>
        
        <div class="relative z-10 text-center px-6 fade-up">
            <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-4">The Company</p>
            <h2 class="text-4xl md:text-6xl lg:text-8xl font-black text-white tracking-tighter uppercase mb-6">Redefining<br>Energy</h2>
            <p class="text-white/40 text-sm md:text-base max-w-xl mx-auto leading-relaxed">
                Magnatic EV is at the forefront of the electric revolution in India. We engineer high-density, ultra-safe lithium-ion battery packs that power the next generation of mobility.
            </p>
        </div>
    </section>

    {{-- GRID SECTION --}}
    <section class="bg-black py-24 md:py-32 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24">
            
            <div class="fade-up">
                <h3 class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-6">Our Mission</h3>
                <h4 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6 leading-none">Powering India's Transition.</h4>
                <p class="text-white/40 text-sm leading-relaxed">
                    We believe the future of transportation is electric. Our mission is to accelerate this transition by providing reliable, high-performance battery solutions that eliminate range anxiety and reduce the total cost of ownership for everyday riders and commercial fleets.
                </p>
            </div>

            <div class="fade-up">
                <h3 class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-6">Our Vision</h3>
                <h4 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6 leading-none">Zero Emissions. Infinite Miles.</h4>
                <p class="text-white/40 text-sm leading-relaxed">
                    To be the driving force behind a carbon-neutral ecosystem. We envision a world where every two-wheeler and three-wheeler operates on clean, sustainable energy, powered by our advanced battery technologies.
                </p>
            </div>

        </div>
    </section>

    {{-- STATS STRIP --}}
    <section class="bg-black py-16 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-white/5">
                <div class="text-center px-4 fade-up">
                    <div class="text-4xl md:text-6xl font-black text-white mb-2">50k+</div>
                    <div class="text-white/30 text-[9px] uppercase tracking-widest">Packs Delivered</div>
                </div>
                <div class="text-center px-4 fade-up">
                    <div class="text-4xl md:text-6xl font-black text-white mb-2">10M+</div>
                    <div class="text-white/30 text-[9px] uppercase tracking-widest">Clean Kilometers</div>
                </div>
                <div class="text-center px-4 fade-up">
                    <div class="text-4xl md:text-6xl font-black text-white mb-2">99%</div>
                    <div class="text-white/30 text-[9px] uppercase tracking-widest">Uptime</div>
                </div>
                <div class="text-center px-4 fade-up">
                    <div class="text-4xl md:text-6xl font-black text-white mb-2">15+</div>
                    <div class="text-white/30 text-[9px] uppercase tracking-widest">Cities Served</div>
                </div>
            </div>
        </div>
    </section>

@endsection
