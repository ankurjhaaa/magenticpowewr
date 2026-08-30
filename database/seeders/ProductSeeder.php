<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::query()->first();
        $brand = Brand::query()->first();

        if (! $category || ! $brand) {
            return;
        }

        Product::query()->firstOrCreate(
            ['slug' => 'lfp-ev-battery'],
            [
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => 'LFP EV Battery',
                'short_description' => 'LFP battery pack for electric vehicles.',
                'description' => 'A durable, safe LFP (Lithium Iron Phosphate) battery pack designed for electric vehicles, with BMS integration and multiple capacity variants.',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );
    }
}
