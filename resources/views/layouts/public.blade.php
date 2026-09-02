<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Magnetic EV — Advanced Lithium-Ion Batteries for Electric Mobility')</title>
    <meta name="description" content="@yield('meta_description', 'Magnetic EV — High-performance lithium-ion battery solutions for electric scooters and two-wheelers in India.')">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/public.css', 'resources/js/app.js'])
</head>
<body class="bg-carbon-900 text-white antialiased font-sans selection:bg-brand-500 selection:text-black flex flex-col min-h-screen">
    
    {{-- Cinematic Transparent Header --}}
    <header class="fixed top-0 inset-x-0 z-50 transition-all duration-500 bg-transparent border-b border-transparent" id="main-header">
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
                        <span class="text-xl font-black tracking-tight text-white uppercase">magnetic<span class="text-brand-500">ev</span></span>
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
                                <div class="w-1/4 border-r border-white/5 p-8 flex flex-col h-full">
                                    <span class="text-[9px] uppercase tracking-widest font-bold text-white/40 mb-6 block shrink-0">Categories</span>
                                    <div class="flex-1 flex flex-col gap-2 overflow-y-auto hide-scrollbar pb-4">
                                        @foreach($sidebarCategories as $index => $category)
                                            <button type="button" 
                                                    class="mega-category-btn text-left px-5 py-4 text-xs font-bold uppercase tracking-widest transition-all shrink-0 hover:bg-white/5 {{ $index === 0 ? 'text-brand-500 bg-white/5 border-l-2 border-brand-500' : 'text-white border-l-2 border-transparent' }}"
                                                    data-target="mega-products-{{ $category->id }}"
                                                    onmouseenter="showMegaProducts('{{ $category->id }}', this)">
                                                {{ $category->name }}
                                            </button>
                                        @endforeach
                                    </div>
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
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['support_whatsapp'] ?? '919876543210') }}?text={{ urlencode('Hi, I am interested in Magnetic Power battery solutions.') }}" 
                   target="_blank" rel="noopener noreferrer"
                   class="text-[#25D366] hover:text-[#128C7E] text-[11px] sm:text-xs font-bold uppercase tracking-widest transition-colors flex items-center gap-2">
                    <svg class="w-6 h-6 lg:w-4 lg:h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    <span class="hidden lg:inline">WhatsApp</span>
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

        {{-- Sidebar Content (Scrollable) --}}
        <div class="flex-1 overflow-y-auto hide-scrollbar p-6 flex flex-col gap-6">
            
            {{-- Categories Section (Top) --}}
            <div class="flex flex-col">
                <a href="{{ route('products') }}" class="text-sm font-black uppercase tracking-widest text-white hover:text-brand-500 mb-4 flex items-center justify-between group transition-colors">
                    All Batteries
                    <span class="text-brand-500 group-hover:translate-x-1 transition-transform">&rarr;</span>
                </a>
                
                @if(isset($sidebarCategories) && $sidebarCategories->count() > 0)
                    <div class="flex flex-col gap-2">
                        @foreach($sidebarCategories as $category)
                            <div class="border border-white/5 bg-white/[0.02]">
                                <button type="button" class="w-full flex items-center justify-between p-3 text-left hover:bg-white/[0.05] transition-colors group" onclick="toggleAccordion('cat-{{ $category->id }}')">
                                    <span class="text-[11px] font-bold uppercase tracking-widest text-white/80 group-hover:text-brand-500 transition-colors">{{ $category->name }}</span>
                                    <svg class="h-4 w-4 text-white/30 transition-transform duration-300 transform" id="icon-cat-{{ $category->id }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div id="cat-{{ $category->id }}" class="hidden px-4 pb-3 flex flex-col gap-2 pt-1 border-t border-white/5 mx-3">
                                    @foreach($category->products as $sidebarProduct)
                                        <a href="{{ route('products.show', $sidebarProduct->slug) }}" class="flex items-center gap-3 py-1.5 bg-transparent hover:bg-white/[0.05] transition-colors group/prod">
                                            <div class="w-8 h-8 bg-black border border-white/5 flex items-center justify-center shrink-0 p-1">
                                                @if($sidebarProduct->images->count() > 0)
                                                    <img src="{{ Storage::url($sidebarProduct->images->first()->image_path) }}" class="w-full h-full object-contain group-hover/prod:scale-110 transition-transform duration-300">
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[10px] uppercase font-bold text-white group-hover/prod:text-brand-500 transition-colors leading-tight">{{ $sidebarProduct->name }}</span>
                                                <span class="text-[8px] text-white/30 uppercase tracking-widest mt-0.5">{{ Str::limit($sidebarProduct->short_description, 25) }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="w-full h-px bg-white/5 shrink-0"></div>

            {{-- Main Links (Bottom) --}}
            <nav class="flex flex-col gap-4 shrink-0">
                <a href="{{ route('home') }}" class="text-lg font-black uppercase tracking-widest {{ request()->routeIs('home') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-lg font-black uppercase tracking-widest {{ request()->routeIs('about') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">About Us</a>
                <a href="{{ route('technology') }}" class="text-lg font-black uppercase tracking-widest {{ request()->routeIs('technology') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Technology</a>
                <a href="{{ route('contact') }}" class="text-lg font-black uppercase tracking-widest {{ request()->routeIs('contact') ? 'text-brand-500' : 'text-white hover:text-brand-500' }} transition-colors">Contact</a>
            </nav>

        </div>

        {{-- Fixed Bottom WhatsApp Block --}}
        <div class="shrink-0 p-6 border-t border-white/5 bg-black/50 backdrop-blur-md">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['support_whatsapp'] ?? '919876543210') }}?text={{ urlencode('Hi, I am interested in Magnetic Power battery solutions.') }}" 
               target="_blank" rel="noopener noreferrer"
               class="flex items-center justify-center gap-3 bg-[#25D366] text-black w-full py-4 text-xs font-bold uppercase tracking-widest hover:bg-[#128C7E] transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                Message on WhatsApp
            </a>
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

        // Header Scroll Effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('bg-black/80', 'backdrop-blur-md', 'border-white/10');
                header.classList.remove('bg-transparent', 'border-transparent');
            } else {
                header.classList.remove('bg-black/80', 'backdrop-blur-md', 'border-white/10');
                header.classList.add('bg-transparent', 'border-transparent');
            }
        });
    </script>

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Brutalist Cinematic Footer --}}
    <footer class="bg-black border-t border-white/5 relative z-20 overflow-hidden">
        
      

        {{-- Main Footer Links --}}
        <div class="mx-auto w-full max-w-7xl px-6 lg:px-12 py-16 lg:py-24 relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                
                {{-- Column 1: Brand Info --}}
                <div class="flex flex-col gap-6 lg:pr-8">
                    <a href="/" class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-xl font-black tracking-tight text-white uppercase">magnetic<span class="text-brand-500">ev</span></span>
                    </a>
                    <p class="text-white/40 text-xs leading-relaxed font-mono">Advanced lithium-ion battery architectures built for extreme endurance.</p>
                    
                    {{-- Social Links --}}
                    <div class="flex items-center gap-4 mt-2">
                        @if(!empty($siteSettings['social_facebook']))
                            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" class="text-white/40 hover:text-brand-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social_instagram']))
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" class="text-white/40 hover:text-brand-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social_twitter']))
                            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" class="text-white/40 hover:text-brand-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                        @endif
                        @if(!empty($siteSettings['social_linkedin']))
                            <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" class="text-white/40 hover:text-brand-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Column 2: Navigation & Categories --}}
                <div class="flex flex-col gap-4">
                    <span class="text-[10px] font-bold text-white/20 uppercase tracking-widest border-b border-white/5 pb-3 mb-2">Our Solutions</span>
                    @if(isset($sidebarCategories) && $sidebarCategories->count() > 0)
                        @foreach($sidebarCategories as $category)
                            <a href="{{ route('products') }}?category={{ $category->slug }}" class="text-xs font-bold text-white/60 hover:text-brand-500 hover:translate-x-1 transition-all uppercase tracking-widest w-fit">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @endif
                    <a href="/products" class="text-[10px] font-bold text-brand-500 hover:text-white transition-all uppercase tracking-widest w-fit mt-2">View All Batteries &rarr;</a>
                </div>

                {{-- Column 3: Contact Info --}}
                <div class="flex flex-col gap-4">
                    <span class="text-[10px] font-bold text-white/20 uppercase tracking-widest border-b border-white/5 pb-3 mb-2">Connect</span>
                    <a href="/about" class="text-xs font-bold text-white/60 hover:text-brand-500 hover:translate-x-1 transition-all uppercase tracking-widest w-fit">Company</a>
                    <a href="/technology" class="text-xs font-bold text-white/60 hover:text-brand-500 hover:translate-x-1 transition-all uppercase tracking-widest w-fit">Technology</a>
                    <a href="/contact" class="text-xs font-bold text-white/60 hover:text-brand-500 hover:translate-x-1 transition-all uppercase tracking-widest w-fit">Support</a>
                    <a href="mailto:{{ $siteSettings['support_email'] ?? 'support@magneticev.com' }}" class="text-[11px] font-mono text-white/60 hover:text-brand-500 transition-colors w-fit mt-2">
                        {{ $siteSettings['support_email'] ?? 'hello@magneticev.com' }}
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['support_phone'] ?? '+919876543210') }}" class="text-[11px] font-mono text-white/60 hover:text-brand-500 transition-colors w-fit">
                        {{ $siteSettings['support_phone'] ?? '+91 98765 43210' }}
                    </a>
                </div>

                {{-- Column 4: WhatsApp Direct --}}
                <div class="flex flex-col gap-4">
                    <span class="text-[10px] font-bold text-white/20 uppercase tracking-widest border-b border-white/5 pb-3 mb-2">Direct Line</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['support_whatsapp'] ?? '919876543210') }}?text={{ urlencode('Hi, I am interested in Magnetic Power battery solutions.') }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-3 bg-[#25D366]/10 border border-[#25D366]/30 px-4 py-3 text-xs font-bold text-[#25D366] hover:bg-[#25D366] hover:text-black transition-colors uppercase tracking-widest w-max mt-2">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Huge Watermark Text --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden flex items-end justify-center pointer-events-none select-none opacity-[0.02] z-0">
            <h1 class="text-[20vw] font-black leading-[0.7] text-white whitespace-nowrap">MAGNETIC</h1>
        </div>

        {{-- Bottom Copyright Bar --}}
        <div class="border-t border-white/5 bg-black relative z-10">
            <div class="mx-auto w-full max-w-7xl px-6 lg:px-12 py-6 flex flex-col md:flex-row items-center justify-between gap-4 text-[10px] text-white/30 font-mono uppercase tracking-widest">
                <p>&copy; {{ date('Y') }} Magnetic EV. All systems operational.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-brand-500 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-500 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
