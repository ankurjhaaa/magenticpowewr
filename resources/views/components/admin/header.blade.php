@props(['title' => 'Dashboard'])

<header class="h-16 flex items-center justify-between gap-4 px-4 lg:px-8 border-b border-gray-200 bg-white shrink-0">
    <div class="flex items-center gap-3 min-w-0">
        <button
            type="button"
            @click="sidebarOpen = true"
            class="lg:hidden p-2 -ml-2 rounded-md text-gray-500 hover:bg-gray-100 cursor-pointer"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-gray-900 truncate">{{ $title }}</h1>
    </div>

    <div x-data="{ open: false }" class="relative shrink-0">
        <button
            type="button"
            @click="open = ! open"
            @click.outside="open = false"
            class="flex items-center gap-2 cursor-pointer"
        >
            <span class="w-8 h-8 rounded-full bg-gray-900 text-white text-xs font-semibold flex items-center justify-center">
                {{ auth()->user()?->initials() }}
            </span>
            <span class="hidden sm:block text-sm font-medium text-gray-700">{{ auth()->user()?->name }}</span>
            <svg class="hidden sm:block w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-show="open"
            x-cloak
            x-transition
            class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-50"
        >
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
