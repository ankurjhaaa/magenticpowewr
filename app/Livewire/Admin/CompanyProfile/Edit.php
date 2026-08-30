<?php

namespace App\Livewire\Admin\CompanyProfile;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin', ['title' => 'Company Profile'])]
class Edit extends Component
{
    use WithFileUploads;

    public string $company_name = '';
    public ?string $tagline = null;
    public ?string $about = null;
    public ?string $vision = null;
    public ?string $mission = null;
    public ?string $established_year = null;
    public ?string $existingLogo = null;
    public $logo;

    public function mount(): void
    {
        $profile = CompanyProfile::query()->first();

        if ($profile) {
            $this->company_name = $profile->company_name;
            $this->tagline = $profile->tagline;
            $this->about = $profile->about;
            $this->vision = $profile->vision;
            $this->mission = $profile->mission;
            $this->established_year = $profile->established_year;
            $this->existingLogo = $profile->logo;
        }
    }

    protected function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:150'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'established_year' => ['nullable', 'digits:4'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $profile = CompanyProfile::query()->first() ?? new CompanyProfile();

        $profile->company_name = $this->company_name;
        $profile->tagline = $this->tagline;
        $profile->about = $this->about;
        $profile->vision = $this->vision;
        $profile->mission = $this->mission;
        $profile->established_year = $this->established_year;

        if ($this->logo) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }

            $profile->logo = $this->logo->store('company', 'public');
            $this->existingLogo = $profile->logo;
            $this->logo = null;
        }

        $profile->save();

        $this->dispatch('toast', message: 'Company profile updated.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.company-profile.edit');
    }
}
