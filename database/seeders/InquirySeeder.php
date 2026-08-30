<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $variant = ProductVariant::with('product')->first();

        Inquiry::query()->firstOrCreate(
            ['phone' => '9876543210'],
            [
                'variant_id' => $variant?->id,
                'product_name_snapshot' => $variant?->product?->name,
                'variant_name_snapshot' => $variant?->name,
                'name' => 'Rahul Sharma',
                'email' => 'rahul.sharma@example.com',
                'company_name' => null,
                'message' => 'Hi, I am interested in this battery variant. Please share pricing and availability.',
                'source' => 'website',
                'status' => 'new',
            ]
        );
    }
}
