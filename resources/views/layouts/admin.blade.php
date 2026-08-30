<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Magnetic Power Battery') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 antialiased h-screen overflow-hidden">
    <div x-data="{ sidebarOpen: false }" class="h-full flex">

        {{-- Desktop sidebar --}}
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:shrink-0 h-full overflow-hidden border-r border-gray-200 bg-white">
            <x-admin.sidebar />
        </aside>

        {{-- Mobile off-canvas sidebar --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            class="fixed inset-0 z-40 lg:hidden"
            role="dialog"
            aria-modal="true"
        >
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 bg-gray-900/50"
            ></div>

            <div
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative flex flex-col w-72 max-w-[80%] h-full bg-white border-r border-gray-200"
            >
                <button
                    @click="sidebarOpen = false"
                    class="absolute top-3 right-3 p-2 rounded-md text-gray-500 hover:bg-gray-100 cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <x-admin.sidebar />
            </div>
        </div>

        {{-- Main column --}}
        <div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden">
            <x-admin.header :title="$title ?? 'Dashboard'" />

            <main class="thin-scrollbar flex-1 overflow-y-auto p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-admin.toast />

    @livewireScripts
</body>
</html>
