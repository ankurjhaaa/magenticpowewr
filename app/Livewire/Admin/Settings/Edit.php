<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin', ['title' => 'Settings'])]
class Edit extends Component
{
    use WithFileUploads;

    public $logo;
    public ?string $existingLogo = null;

    public ?string $facebook_url = null;
    public ?string $instagram_url = null;
    public ?string $youtube_url = null;
    public ?string $linkedin_url = null;
    public ?string $twitter_url = null;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->existingLogo = Setting::get('site_logo');
        $this->facebook_url = Setting::get('facebook_url');
        $this->instagram_url = Setting::get('instagram_url');
        $this->youtube_url = Setting::get('youtube_url');
        $this->linkedin_url = Setting::get('linkedin_url');
        $this->twitter_url = Setting::get('twitter_url');
    }

    public function saveLogo(): void
    {
        $this->validate([
            'logo' => ['required', 'image', 'max:2048'],
        ]);

        if ($this->existingLogo) {
            Storage::disk('public')->delete($this->existingLogo);
        }

        $path = $this->logo->store('settings', 'public');
        Setting::set('site_logo', $path, 'general', 'image');

        $this->existingLogo = $path;
        $this->logo = null;

        $this->dispatch('toast', message: 'Logo updated.', type: 'success');
    }

    public function saveSocialLinks(): void
    {
        $this->validate([
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
        ]);

        Setting::set('facebook_url', $this->facebook_url, 'social');
        Setting::set('instagram_url', $this->instagram_url, 'social');
        Setting::set('youtube_url', $this->youtube_url, 'social');
        Setting::set('linkedin_url', $this->linkedin_url, 'social');
        Setting::set('twitter_url', $this->twitter_url, 'social');

        $this->dispatch('toast', message: 'Social links updated.', type: 'success');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'The current password is incorrect.');

            return;
        }

        Auth::user()->update(['password' => $this->password]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        $this->dispatch('toast', message: 'Password updated.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.settings.edit');
    }
}
