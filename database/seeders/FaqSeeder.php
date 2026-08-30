<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::query()->firstOrCreate(
            ['question' => 'What types of batteries does Magnetic Power manufacture?'],
            [
                'answer' => 'We manufacture LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) lithium-ion batteries for electric vehicles, e-scooters, e-rickshaws and energy storage systems.',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }
}
