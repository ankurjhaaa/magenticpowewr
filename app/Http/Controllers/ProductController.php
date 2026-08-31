<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->ordered()->get();
        
        $query = Product::active()->with([
            'category',
            'images' => fn ($q) => $q->orderByDesc('is_primary')->orderBy('sort_order'),
        ]);

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->get();

        return view('products.index', compact('categories', 'products'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        
        $product->load([
            'category', 
            'images' => fn ($q) => $q->orderByDesc('is_primary')->orderBy('sort_order'),
            'variants'
        ]);

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn ($q) => $q->orderByDesc('is_primary')->orderBy('sort_order')])
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
