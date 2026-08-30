<div class="w-full max-w-md mx-auto">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gray-900 text-white font-bold text-lg mb-4">
            MP
        </div>
        <h1 class="text-2xl font-semibold text-gray-900">Magnetic Power Battery</h1>
        <p class="text-sm text-gray-500 mt-1">Sign in to the admin panel</p>
    </div>

    <div class="bg-white shadow-lg shadow-gray-200/60 border border-gray-200 rounded-2xl p-8">
        <form wire:submit="login" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input wire:model="email" id="email" type="email" autocomplete="username" autofocus
                    placeholder="you@example.com"
                    class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input wire:model="password" id="password" type="password" autocomplete="current-password"
                    placeholder="••••••••"
                    class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition">
                @error('password')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600 select-none">
                <input wire:model="remember" type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                Remember me
            </label>

            <button type="submit"
                class="w-full inline-flex justify-center items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed transition"
                wire:loading.attr="disabled" wire:target="login">
                <svg wire:loading wire:target="login" class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login">Signing in...</span>
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} Magnetic Power Battery. All rights reserved.</p>
</div>
