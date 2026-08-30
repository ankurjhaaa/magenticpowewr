<div class="space-y-8 max-w-3xl">
    {{-- Logo --}}
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-1">Site Logo</h2>
        <p class="text-sm text-gray-500 mb-4">Used in the admin sidebar and on the public website.</p>

        <form wire:submit="saveLogo" class="space-y-4">
            @if ($existingLogo && ! $logo)
                <img src="{{ Storage::url($existingLogo) }}" class="w-20 h-20 rounded-lg object-cover border border-gray-200">
            @endif

            <div class="flex items-center gap-3">
                <input type="file" wire:model="logo" accept="image/*" class="text-sm text-gray-600">
                <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="logo,saveLogo">
                    Upload
                </x-admin.button>
            </div>
            <div wire:loading wire:target="logo" class="text-xs text-gray-400">Uploading...</div>
            @error('logo') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </form>
    </div>

    {{-- Social Links --}}
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-1">Social Links</h2>
        <p class="text-sm text-gray-500 mb-4">Shown in the public website footer.</p>

        <form wire:submit="saveSocialLinks" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                <input type="text" wire:model="facebook_url" placeholder="https://facebook.com/yourpage" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('facebook_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                <input type="text" wire:model="instagram_url" placeholder="https://instagram.com/yourpage" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('instagram_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                <input type="text" wire:model="youtube_url" placeholder="https://youtube.com/@yourchannel" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('youtube_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                <input type="text" wire:model="linkedin_url" placeholder="https://linkedin.com/company/yourcompany" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('linkedin_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Twitter / X URL</label>
                <input type="text" wire:model="twitter_url" placeholder="https://x.com/yourhandle" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('twitter_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end pt-2">
                <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="saveSocialLinks">
                    Save Social Links
                </x-admin.button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-1">Change Password</h2>
        <p class="text-sm text-gray-500 mb-4">Update your admin login password.</p>

        <form wire:submit="updatePassword" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" wire:model="current_password" autocomplete="current-password" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('current_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" wire:model="password" autocomplete="new-password" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" wire:model="password_confirmation" autocomplete="new-password" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="updatePassword">
                    Update Password
                </x-admin.button>
            </div>
        </form>
    </div>
</div>
