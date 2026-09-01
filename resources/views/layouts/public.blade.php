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
    <header class="fixed top-0 inset-x-0 z-50 transition-all duration-500 bg-black/50 backdrop-blur-md border-b border-white/5" id="main-header">
        <nav class="relative w-full h-20 flex items-center justify-between px-6 lg:px-12">
            
            {{-- Left: Mobile Menu & Desktop Logo --}}
            <div class="flex flex-1 justify-start items-center gap-4">
                {{-- Mobile Menu Toggle (Hidden on Desktop) --}}
                <div class="lg:hidden">
                    @hasSection('header_left')
                        @yield('header_left')
                    @else
                        <button type="button" class="text-white hover:text-brand-500 transition-colors focus:outline-none flex items-center gap-3 group" onclick="toggleSidebar()">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <span class="hidden sm:block text-[9px] uppercase tracking-widest font-bold group-hover:text-white transition-colors">Menu</span>
                        </button>
                    @endif
                </div>

                {{-- Logo (Centered on Mobile via Absolute, Static Left on Desktop) --}}
                <div class="absolute left-1/2 -translate-x-1/2 lg:static lg:translate-x-0 flex justify-center items-center">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <span class="text-xl font-black tracking-tight text-white uppercase">magnatic<span class="text-brand-500">ev</span></span>
                    </a>
                </div>
            </div>

            {{-- Center: Desktop Nav Links (Hidden on Mobile) --}}
            <div class="hidden lg:flex flex-[2] justify-center items-center h-full">
                <div class="flex items-center gap-10 h-full">
                    <a href="{{ route('home') }}" class="text-[10px] font-bold uppercase tracking-widest {{ request()->routeIs('home') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Home</a>
                    <a href="{{ route('about') }}" class="text-[10px] font-bold uppercase tracking-widest {{ request()->routeIs('about') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">About</a>
                    
                    {{-- Batteries Mega Menu Trigger --}}
                    <div class="relative h-full flex items-center group/nav" id="desktop-mega-menu-trigger">
                        <a href="{{ route('products') }}" class="text-[10px] font-bold uppercase tracking-widest {{ request()->is('products*') ? 'text-brand-500' : 'text-white group-hover/nav:text-brand-500' }} transition-colors flex items-center gap-1">
                            Batteries
                            <svg class="w-3 h-3 transition-transform duration-300 group-hover/nav:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        
                        {{-- Mega Menu Dropdown Panel (Full Width) --}}
                        <div class="fixed top-20 inset-x-0 bg-black/95 backdrop-blur-xl border-y border-white/10 opacity-0 invisible group-hover/nav:opacity-100 group-hover/nav:visible transition-all duration-300 z-40 shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                            <div class="max-w-7xl mx-auto flex h-[400px]">
                                {{-- Mega Menu Left: Categories --}}
                                <div class="w-1/4 border-r border-white/5 p-8 flex flex-col gap-2">
                                    <span class="text-[9px] uppercase tracking-widest font-bold text-white/40 mb-6 block">Categories</span>
                                    @foreach($sidebarCategories as $index => $category)
                                        <button type="button" 
                                                class="mega-category-btn text-left px-5 py-4 text-xs font-bold uppercase tracking-widest transition-all hover:bg-white/5 {{ $index === 0 ? 'text-brand-500 bg-white/5 border-l-2 border-brand-500' : 'text-white border-l-2 border-transparent' }}"
                                                data-target="mega-products-{{ $category->id }}"
                                                onmouseenter="showMegaProducts('{{ $category->id }}', this)">
                                            {{ $category->name }}
                                        </button>
                                    @endforeach
                                </div>

                                {{-- Mega Menu Right: Products (Dynamic) --}}
                                <div class="w-3/4 p-8 relative overflow-hidden">
                                    @foreach($sidebarCategories as $index => $category)
                                        <div id="mega-products-{{ $category->id }}" class="mega-products-panel absolute inset-0 p-8 grid grid-cols-4 gap-6 {{ $index === 0 ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }} transition-opacity duration-300">
                                            @foreach($category->products->take(4) as $product)
                                                <a href="{{ route('products.show', $product->slug) }}" class="group/product flex flex-col items-center">
                                                    <div class="w-full aspect-square bg-white/[0.02] border border-white/5 mb-4 flex items-center justify-center p-4 group-hover/product:border-brand-500/50 transition-colors">
                                                        @if($product->images->count() > 0)
                                                            <img src="{{ Storage::url($product->images->first()->image_path) }}" class="w-full h-full object-contain group-hover/product:scale-110 transition-transform duration-500">
                                                        @else
                                                            <span class="text-white/10 text-[8px] uppercase">No Image</span>
                                                        @endif
                                                    </div>
                                                    <h4 class="text-white text-[10px] font-bold uppercase tracking-widest text-center group-hover/product:text-brand-500 transition-colors">{{ Str::limit($product->name, 25) }}</h4>
                                                </a>
                                            @endforeach
                                            
                                            @if($category->products->count() > 4)
                                                <div class="col-span-4 flex justify-center items-end pb-2">
                                                    <a href="{{ route('products') }}?category={{ $category->slug }}" class="text-white/50 hover:text-brand-500 text-[10px] uppercase tracking-widest font-bold transition-colors">View All {{ $category->name }} &rarr;</a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('technology') }}" class="text-[10px] font-bold uppercase tracking-widest {{ request()->routeIs('technology') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Technology</a>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex-1 flex justify-end items-center">
                <a href="{{ route('contact') }}" class="text-white hover:text-brand-500 text-[11px] sm:text-xs font-bold uppercase tracking-widest transition-colors">
                    Inquire 
                </a>
            </div>
        </nav>
    </header>

    {{-- Off-Canvas Global Sidebar --}}
    <div id="global-sidebar" class="fixed top-0 left-0 h-[100dvh] w-full sm:w-96 bg-black/95 backdrop-blur-xl border-r border-white/5 z-[60] transform -translate-x-full transition-transform duration-500 flex flex-col">
        {{-- Sidebar Header --}}
        <div class="h-20 shrink-0 border-b border-white/5 flex items-center justify-between px-8">
            <span class="text-[10px] uppercase tracking-widest font-bold text-white/50">Navigation</span>
            <button type="button" class="text-white hover:text-brand-500 transition-colors p-2 -mr-2" onclick="toggleSidebar()">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="square" stroke-linejoin="miter" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Sidebar Content --}}
        <div class="flex-1 overflow-y-auto hide-scrollbar p-8 flex flex-col gap-8 pb-24">
            
            {{-- Main Links --}}
            <nav class="flex flex-col gap-4">
                <a href="{{ route('home') }}" class="text-xl font-bold uppercase tracking-widest {{ request()->routeIs('home') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-xl font-bold uppercase tracking-widest {{ request()->routeIs('about') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">About Us</a>
                <a href="{{ route('technology') }}" class="text-xl font-bold uppercase tracking-widest {{ request()->routeIs('technology') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Technology</a>
                <a href="{{ route('contact') }}" class="text-xl font-bold uppercase tracking-widest {{ request()->routeIs('contact') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Contact</a>
            </nav>

            <div class="w-full h-px bg-white/5"></div>

            {{-- Categories Accordion --}}
            <div>
                <span class="text-[10px] uppercase tracking-widest font-bold text-white/50 mb-6 block">Our Solutions</span>
                <a href="{{ route('products') }}" class="text-sm font-bold uppercase tracking-widest text-brand-500 mb-4 block hover:text-brand-400 transition-colors">View All Batteries</a>
                
                @if(isset($sidebarCategories) && $sidebarCategories->count() > 0)
                    <div class="flex flex-col gap-2">
                        @foreach($sidebarCategories as $category)
                            <div class="border border-white/5 bg-white/[0.02]">
                                <button type="button" class="w-full flex items-center justify-between p-4 text-left hover:bg-white/[0.05] transition-colors" onclick="toggleAccordion('cat-{{ $category->id }}')">
                                    <span class="text-[11px] font-bold uppercase tracking-widest text-white">{{ $category->name }}</span>
                                    <svg class="h-4 w-4 text-white/50 transition-transform duration-300 transform" id="icon-cat-{{ $category->id }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div id="cat-{{ $category->id }}" class="hidden px-4 pb-4 flex flex-col gap-3 pt-2">
                                    @foreach($category->products as $sidebarProduct)
                                        <a href="{{ route('products.show', $sidebarProduct->slug) }}" class="flex items-center gap-3 p-2 bg-white/[0.01] hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/10 group">
                                            <div class="w-10 h-10 bg-black border border-white/5 flex items-center justify-center shrink-0">
                                                @if($sidebarProduct->images->count() > 0)
                                                    <img src="{{ Storage::url($sidebarProduct->images->first()->image_path) }}" class="w-full h-full object-contain p-1 group-hover:scale-110 transition-transform duration-300">
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] uppercase font-bold text-white group-hover:text-brand-500 transition-colors leading-tight">{{ $sidebarProduct->name }}</span>
                                                <span class="text-[8px] text-white/40 uppercase tracking-widest mt-0.5">{{ Str::limit($sidebarProduct->short_description, 20) }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Sidebar Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[55] hidden transition-opacity opacity-0 duration-500" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('global-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                // Trigger reflow to animate opacity
                void overlay.offsetWidth;
                overlay.classList.remove('opacity-0');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 500);
            }
        }

        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Mega Menu Interaction Logic
        function showMegaProducts(categoryId, btnElement) {
            // 1. Hide all product panels
            const panels = document.querySelectorAll('.mega-products-panel');
            panels.forEach(panel => {
                panel.classList.remove('opacity-100', 'pointer-events-auto');
                panel.classList.add('opacity-0', 'pointer-events-none');
            });

            // 2. Show the targeted product panel
            const targetPanel = document.getElementById('mega-products-' + categoryId);
            if(targetPanel) {
                targetPanel.classList.remove('opacity-0', 'pointer-events-none');
                targetPanel.classList.add('opacity-100', 'pointer-events-auto');
            }

            // 3. Reset all category buttons to default state
            const buttons = document.querySelectorAll('.mega-category-btn');
            buttons.forEach(btn => {
                btn.classList.remove('text-brand-500', 'bg-white/5', 'border-brand-500');
                btn.classList.add('text-white', 'border-transparent');
            });

            // 4. Highlight the hovered button
            btnElement.classList.remove('text-white', 'border-transparent');
            btnElement.classList.add('text-brand-500', 'bg-white/5', 'border-brand-500');
        }
    </script>

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
