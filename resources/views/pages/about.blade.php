@extends('layouts.public')

@section('title', 'About ' . ($company?->company_name ?? 'Magnetic Power Battery'))
@section('meta_description', $company?->tagline ?? 'Advanced Lithium Battery Manufacturing for a Smarter Electric Future.')

@section('content')

    {{-- HERO --}}
    <section class="min-h-[70vh] w-full bg-black relative flex items-center justify-center overflow-hidden border-b border-white/5 pt-20">
        <div class="absolute inset-0 flex items-center justify-center z-0 opacity-5 pointer-events-none select-none">
            <h1 class="text-[30vw] font-black text-white whitespace-nowrap">ABOUT</h1>
        </div>

        <div class="relative z-10 text-center px-6 fade-up max-w-3xl mx-auto">
            <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-4">The Company</p>
            <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase mb-6 leading-none">
                Advanced Lithium Battery<br>Manufacturing
            </h2>
            <p class="text-white/40 text-sm md:text-base leading-relaxed">
                {{ $company?->about ?? 'Magnetic Power Battery is a professional Lithium-ion Battery Manufacturer specializing in advanced LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) battery technologies.' }}
            </p>
            <p class="text-white/40 text-sm md:text-base leading-relaxed mt-4">
                We manufacture reliable and high-performance battery packs designed for Electric Vehicles, E-Scooters, E-Rickshaws, Energy Storage Systems and other electric mobility applications.
            </p>
        </div>
    </section>

    {{-- OUR EXPERTISE --}}
    <section class="bg-black py-24 md:py-32 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24 items-start">
            <div class="fade-up">
                <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-6">Our Expertise</p>
                <h3 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6 leading-none">
                    Built Around Your Application.
                </h3>
                <p class="text-white/40 text-sm leading-relaxed">
                    With a focus on quality, technology and performance, we manufacture battery solutions according to the specific requirements of different EV applications.
                </p>
            </div>

            <div class="fade-up">
                <p class="text-white/50 text-sm uppercase tracking-widest font-semibold mb-6">Our battery portfolio includes</p>
                <ul class="space-y-4">
                    @foreach ([
                        'LFP Lithium-ion Batteries',
                        'NMC Lithium-ion Batteries',
                        'EV Battery Packs',
                        'Customized Battery Solutions',
                        'BMS Integrated Battery Packs',
                        'Battery Solutions for Electric Mobility & Energy Storage',
                    ] as $item)
                        <li class="flex items-center gap-3 text-white text-sm border-b border-white/5 pb-4">
                            <span class="w-1.5 h-1.5 bg-brand-500 shrink-0"></span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- QUALITY & TECHNOLOGY --}}
    <section class="bg-black py-24 md:py-32 border-b border-white/5">
        <div class="max-w-4xl mx-auto px-6 lg:px-12 text-center fade-up">
            <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-6">Quality &amp; Technology</p>
            <h3 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase mb-8 leading-none">
                The Battery Is The Heart<br>Of Every EV.
            </h3>
            <p class="text-white/40 text-sm md:text-base leading-relaxed">
                At {{ $company?->company_name ?? 'Magnetic Power Battery' }}, we understand that the battery is the heart of every electric vehicle. That is why we focus on quality cells, advanced BMS technology, safety, durability and consistent performance throughout the battery manufacturing process.
            </p>
            <p class="text-white/40 text-sm md:text-base leading-relaxed mt-4">
                Our aim is to provide battery solutions that deliver dependable performance, long service life and excellent value to our customers.
            </p>
        </div>
    </section>

    {{-- MISSION / VISION --}}
    <section class="bg-black py-24 md:py-32 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24">

            <div class="fade-up">
                <h3 class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-6">Our Vision</h3>
                <p class="text-white/70 text-lg md:text-xl font-medium leading-relaxed">
                    {{ $company?->vision ?? 'To become a trusted and innovative Lithium Battery Manufacturing Brand, supporting the rapid growth of electric mobility and clean energy solutions.' }}
                </p>
            </div>

            <div class="fade-up">
                <h3 class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-6">Our Mission</h3>
                <p class="text-white/70 text-lg md:text-xl font-medium leading-relaxed">
                    {{ $company?->mission ?? 'To manufacture safe, reliable and technologically advanced battery solutions that help power the next generation of Electric Vehicles and Energy Storage Systems.' }}
                </p>
            </div>

        </div>
    </section>

    {{-- LEADERSHIP / TEAM MESSAGES --}}
    <section class="bg-black py-24 md:py-32 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="text-center mb-16 fade-up">
                <p class="text-brand-500 text-[10px] font-bold uppercase tracking-[0.4em] mb-4">Leadership</p>
                <h3 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase">Message From Our Leaders</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @forelse ($teamMembers as $member)
                    <div class="fade-up border border-white/5 bg-white/[0.02] p-8 md:p-10 rounded-sm">
                        <div class="flex items-center gap-5 mb-6">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-white/5 border-2 border-brand-500/40 ring-2 ring-white/5 flex items-center justify-center shrink-0">
                                @if ($member->photo)
                                    <img
                                        src="{{ Storage::url($member->photo) }}"
                                        alt="{{ $member->name }}"
                                        class="w-full h-full object-cover object-top"
                                    >
                                @else
                                    <svg class="w-10 h-10 text-white/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">{{ $member->name }}</h4>
                                <p class="text-brand-500 text-xs uppercase tracking-widest font-semibold mt-1">{{ $member->designation }}</p>
                            </div>
                        </div>
                        <p class="text-white/40 text-sm leading-relaxed whitespace-pre-line">&ldquo;{{ $member->message }}&rdquo;</p>
                    </div>
                @empty
                    <p class="text-white/30 text-center md:col-span-2">Team members coming soon.</p>
                @endforelse
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
