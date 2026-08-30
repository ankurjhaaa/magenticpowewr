<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profile = CompanyProfile::query()->first() ?? new CompanyProfile();

        $profile->fill([
            'company_name' => 'Magnetic Power Battery',
            'tagline' => 'Powering Electric Mobility. Driving a Sustainable Future.',
            'about' => 'Magnetic Power Battery is a professional Lithium-ion Battery Manufacturer specializing in advanced LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) battery technologies.',
            'vision' => 'To become a trusted and innovative Lithium Battery Manufacturing Brand, supporting the rapid growth of electric mobility and clean energy solutions.',
            'mission' => 'To manufacture safe, reliable and technologically advanced battery solutions that help power the next generation of Electric Vehicles and Energy Storage Systems.',
        ])->save();
    }
}
