<div class="max-w-3xl">
    <div class="bg-white border border-gray-300 rounded-lg p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-1">Company Profile</h2>
        <p class="text-sm text-gray-500 mb-6">This content is used across the public website (About page, footer, etc.)</p>

        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <input type="text" wire:model="company_name" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                <input type="text" wire:model="tagline" placeholder="e.g. Powering Electric Mobility. Driving a Sustainable Future." class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                @error('tagline') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">About</label>
                <textarea wire:model="about" rows="4" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"></textarea>
                @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vision</label>
                <textarea wire:model="vision" rows="3" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"></textarea>
                @error('vision') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mission</label>
                <textarea wire:model="mission" rows="3" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"></textarea>
                @error('mission') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Established Year</label>
                    <input type="text" wire:model="established_year" placeholder="2020" maxlength="4" class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                    @error('established_year') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                    @if ($existingLogo && ! $logo)
                        <img src="{{ Storage::url($existingLogo) }}" class="w-14 h-14 rounded-lg object-cover border border-gray-200 mb-2">
                    @endif
                    <input type="file" wire:model="logo" accept="image/*" class="block w-full text-sm text-gray-600">
                    <div wire:loading wire:target="logo" class="text-xs text-gray-400 mt-1">Uploading...</div>
                    @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-admin.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                    Save Changes
                </x-admin.button>
            </div>
        </form>
    </div>
</div>
