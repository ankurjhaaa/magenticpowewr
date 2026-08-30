<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::query()->firstOrCreate(
            ['slug' => 'lfp-batteries'],
            [
                'name' => 'LFP Batteries',
                'description' => 'Lithium Iron Phosphate (LFP) battery products.',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }
}
