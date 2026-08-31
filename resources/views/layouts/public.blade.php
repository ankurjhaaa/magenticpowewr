<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Magnatic EV — Advanced Lithium-Ion Batteries for Electric Mobility')</title>
    <meta name="description" content="@yield('meta_description', 'Magnatic EV — High-performance lithium-ion battery solutions for electric scooters and two-wheelers in India.')">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/public.css', 'resources/js/app.js'])
</head>
<body class="bg-carbon-900 text-white antialiased font-sans selection:bg-brand-500 selection:text-black flex flex-col min-h-screen">
    
    {{-- Cinematic Transparent Header --}}
    <header class="fixed top-0 inset-x-0 z-50 transition-all duration-500" id="main-header">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-transparent pointer-events-none"></div>
        
        <nav class="relative mx-auto w-full px-6 lg:px-12 h-20 lg:h-24 flex items-center justify-between">
            
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 z-10 group">
                <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="text-lg font-bold tracking-tight text-white lowercase">magnatic<span class="text-brand-500">ev</span><span class="text-white/40 font-light">.com</span></span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-10 z-10">
                <a href="{{ route('home') }}" class="text-[11px] font-semibold uppercase tracking-[0.2em] {{ request()->routeIs('home') ? 'text-brand-500' : 'text-white/60 hover:text-white' }} transition-colors">Home</a>
                <a href="{{ route('home') }}#about" class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/60 hover:text-white transition-colors">About Us</a>
                <a href="{{ route('products') }}" class="text-[11px] font-semibold uppercase tracking-[0.2em] {{ request()->routeIs('products') ? 'text-brand-500' : 'text-white/60 hover:text-white' }} transition-colors">Batteries</a>
                <a href="{{ route('home') }}#tech-section" class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/60 hover:text-white transition-colors">Technology</a>
                <a href="/contact" class="text-[11px] font-semibold uppercase tracking-[0.2em] text-white/60 hover:text-white transition-colors">Contact</a>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 z-10">
                <a href="/contact" class="hidden sm:inline-flex items-center justify-center bg-brand-500 hover:bg-brand-400 text-black px-6 py-2.5 rounded-full text-[11px] font-bold uppercase tracking-widest transition-colors">
                    Inquire Now
                </a>
                
                {{-- Mobile hamburger --}}
                <button type="button" class="lg:hidden inline-flex items-center justify-center p-2 text-white" id="mobile-menu-btn">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    {{-- Mobile Full-Screen Menu --}}
    <div class="fixed inset-0 z-[60] bg-black/95 backdrop-blur-xl flex flex-col items-center justify-center gap-8 transition-all duration-500 opacity-0 pointer-events-none" id="mobile-menu">
        <button type="button" class="absolute top-6 right-6 text-white p-2" id="mobile-menu-close">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-widest uppercase {{ request()->routeIs('home') ? 'text-brand-500' : 'text-white' }}">Home</a>
        <a href="{{ route('home') }}#about" class="text-2xl font-bold text-white/60 tracking-widest uppercase hover:text-white transition-colors">About Us</a>
        <a href="{{ route('products') }}" class="text-2xl font-bold tracking-widest uppercase hover:text-white transition-colors {{ request()->routeIs('products') ? 'text-brand-500' : 'text-white/60' }}">Batteries</a>
        <a href="{{ route('home') }}#tech-section" class="text-2xl font-bold text-white/60 tracking-widest uppercase hover:text-white transition-colors">Technology</a>
        <a href="/contact" class="text-2xl font-bold text-white/60 tracking-widest uppercase hover:text-white transition-colors">Contact</a>
        <div class="mt-8">
            <a href="/contact" class="px-10 py-4 bg-brand-500 text-black font-bold uppercase tracking-widest rounded-full text-sm">Inquire Now</a>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Minimal Cinematic Footer --}}
    <footer class="bg-black border-t border-white/10 relative z-20 py-16 lg:py-24">
        <div class="mx-auto w-full max-w-7xl px-6 lg:px-12">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-12">
                {{-- Footer Logo --}}
                <div>
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-lg font-bold tracking-tight text-white lowercase">magnatic<span class="text-brand-500">ev</span></span>
                    </a>
                    <p class="text-white/40 text-sm max-w-xs leading-relaxed">Advanced lithium-ion battery solutions for India's electric mobility future.</p>
                </div>

                {{-- Footer Links --}}
                <div class="grid grid-cols-2 gap-x-16 gap-y-4">
                    <a href="/about" class="text-xs font-semibold text-white/40 uppercase tracking-widest hover:text-white transition-colors">About</a>
                    <a href="/products" class="text-xs font-semibold text-white/40 uppercase tracking-widest hover:text-white transition-colors">Batteries</a>
                    <a href="#technology" class="text-xs font-semibold text-white/40 uppercase tracking-widest hover:text-white transition-colors">Technology</a>
                    <a href="/contact" class="text-xs font-semibold text-white/40 uppercase tracking-widest hover:text-white transition-colors">Contact</a>
                </div>
            </div>
            
            <div class="mt-16 pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4 text-[10px] text-white/30 font-medium tracking-widest uppercase">
                <p>&copy; {{ date('Y') }} Magnatic EV. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">LinkedIn</a>
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
