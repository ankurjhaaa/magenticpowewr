<?php

namespace Database\Seeders;

use App\Models\Specification;
use Illuminate\Database\Seeder;

class SpecificationSeeder extends Seeder
{
    public function run(): void
    {
        Specification::query()->firstOrCreate(
            ['name' => 'BMS'],
            [
                'unit' => 'A',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }
}
