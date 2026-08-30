<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::query()->firstOrCreate(
            ['slug' => 'magnetic-power'],
            [
                'name' => 'Magnetic Power',
                'description' => 'Magnetic Power Battery — professional Lithium-ion Battery Manufacturer specializing in LFP and NMC battery technologies.',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }
}
