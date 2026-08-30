<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        Application::query()->firstOrCreate(
            ['slug' => 'electric-scooters'],
            [
                'name' => 'Electric Scooters',
                'description' => 'Battery packs designed for electric scooters.',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }
}
