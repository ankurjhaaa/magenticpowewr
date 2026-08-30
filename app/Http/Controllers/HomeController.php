<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->ordered()->get();

        $categories = Category::active()
            ->ordered()
            ->withCount('products')
            ->limit(6)
            ->get();

        $products = Product::active()
            ->with([
                'category',
                'brand',
                'images' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('sort_order'),
            ])
            ->latest()
            ->limit(8)
            ->get();

        $company = CompanyProfile::query()->first();

        return view('home', compact('banners', 'categories', 'products', 'company'));
    }
}
