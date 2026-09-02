@extends('layouts.public')

@section('title', 'Technology — Magnetic EV')
@section('meta_description', 'Explore the advanced engineering, Smart BMS, and robust cell chemistry that powers Magnetic EV lithium-ion batteries.')

@section('content')

    {{-- HERO --}}
    <section class="min-h-screen w-full bg-black relative flex items-center justify-center overflow-hidden border-b border-white/5 pt-20">
        <div class="absolute inset-0 flex items-center justify-center z-0 opacity-5 pointer-events-none select-none">
            <h1 class="text-[25vw] font-black text-white whitespace-nowrap">TECH</h1>
        </div>
        
        <div class="relative z-10 text-center px-6 w-full max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="flex-1 text-left fade-up">
                <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-4">Engineering</p>
                <h2 class="text-4xl md:text-6xl lg:text-7xl font-black text-white tracking-tighter uppercase mb-6 leading-none">Smart.<br>Safe.<br>Superior.</h2>
                <p class="text-white/40 text-sm md:text-base max-w-md leading-relaxed mb-8">
                    Our proprietary Battery Management System (BMS) and advanced thermal engineering ensure every cell operates in its optimal state, delivering maximum power with zero compromise on safety.
                </p>
            </div>
            
            <div class="flex-1 w-full flex justify-center fade-up relative">
                <div class="w-64 h-64 md:w-96 md:h-96 border border-white/10 rounded-full flex items-center justify-center relative bg-carbon-900">
                    <div class="absolute inset-0 border border-brand-500/20 rounded-full animate-[spin_10s_linear_infinite]"></div>
                    <div class="absolute inset-4 border border-brand-500/10 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
                    <div class="text-center z-10">
                        <div class="text-brand-500 font-black text-4xl mb-1">99.9%</div>
                        <div class="text-[9px] uppercase tracking-widest text-white/40">Efficiency Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES VERTICAL STACK --}}
    <section class="bg-black py-24 md:py-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col gap-32">
            
            {{-- Feature 1 --}}
            <div class="flex flex-col md:flex-row items-center gap-12 md:gap-24 fade-up">
                <div class="flex-1 w-full bg-white/[0.02] border border-white/5 h-[400px] flex items-center justify-center p-8 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-brand-500 to-transparent opacity-50"></div>
                    <h3 class="text-8xl font-black text-white/5 tracking-tighter absolute">BMS</h3>
                    <div class="relative z-10 text-center">
                        <div class="text-brand-500 font-bold mb-4">ACTIVE BALANCING</div>
                        <p class="text-white/40 text-sm">Real-time voltage monitoring and balancing across all cells.</p>
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-brand-500 font-black text-2xl">01</span>
                        <div class="h-px w-8 bg-brand-500/50"></div>
                    </div>
                    <h4 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6">Smart Battery Management</h4>
                    <p class="text-white/40 text-sm leading-relaxed mb-6">
                        The brain behind our batteries. Our Smart BMS protects against overcharging, deep discharging, short circuits, and thermal runaway. It constantly communicates with the vehicle's controller to optimize power delivery based on real-time riding conditions.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Over-voltage Protection</li>
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Thermal Regulation</li>
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Short Circuit Prevention</li>
                    </ul>
                </div>
            </div>

            {{-- Feature 2 --}}
            <div class="flex flex-col-reverse md:flex-row items-center gap-12 md:gap-24 fade-up">
                <div class="flex-1 w-full">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-brand-500 font-black text-2xl">02</span>
                        <div class="h-px w-8 bg-brand-500/50"></div>
                    </div>
                    <h4 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6">Advanced Cell Chemistry</h4>
                    <p class="text-white/40 text-sm leading-relaxed mb-6">
                        We utilize Tier-1 A-grade cells with LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) chemistries. These cells undergo rigorous testing to ensure they deliver high energy density, low internal resistance, and a significantly longer lifecycle compared to standard market alternatives.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> 2000+ Charge Cycles</li>
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Ultra-Low Internal Resistance</li>
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Stable at High Temperatures</li>
                    </ul>
                </div>
                <div class="flex-1 w-full bg-white/[0.02] border border-white/5 h-[400px] flex items-center justify-center p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-px h-full bg-gradient-to-b from-transparent via-brand-500 to-transparent opacity-50"></div>
                    <h3 class="text-8xl font-black text-white/5 tracking-tighter absolute">CELLS</h3>
                    <div class="relative z-10 text-center">
                        <div class="text-brand-500 font-bold mb-4">A-GRADE TIER 1</div>
                        <p class="text-white/40 text-sm">Rigorous capacity matching and internal resistance testing.</p>
                    </div>
                </div>
            </div>

            {{-- Feature 3 --}}
            <div class="flex flex-col md:flex-row items-center gap-12 md:gap-24 fade-up">
                <div class="flex-1 w-full bg-white/[0.02] border border-white/5 h-[400px] flex items-center justify-center p-8 relative overflow-hidden">
                    <div class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-brand-500 to-transparent opacity-50"></div>
                    <h3 class="text-8xl font-black text-white/5 tracking-tighter absolute">IP67</h3>
                    <div class="relative z-10 text-center">
                        <div class="text-brand-500 font-bold mb-4">RUGGED BUILD</div>
                        <p class="text-white/40 text-sm">Laser welded connections in a waterproof aluminum casing.</p>
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-brand-500 font-black text-2xl">03</span>
                        <div class="h-px w-8 bg-brand-500/50"></div>
                    </div>
                    <h4 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6">Built for the Elements</h4>
                    <p class="text-white/40 text-sm leading-relaxed mb-6">
                        Indian roads demand tough engineering. Our battery casings are constructed from aerospace-grade aluminum alloys, offering superior heat dissipation and structural integrity. Every pack is sealed to IP67 standards, making it completely dustproof and waterproof.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> IP67 Water & Dust Resistance</li>
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Anti-Vibration Structure</li>
                        <li class="flex items-center gap-3 text-white/60 text-sm"><span class="w-1.5 h-1.5 bg-brand-500 rounded-none"></span> Aluminum Heat Dissipation</li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

@endsection
