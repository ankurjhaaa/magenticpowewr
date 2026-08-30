<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'products' => Product::count(),
            'variants' => ProductVariant::count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            'new_enquiries' => Inquiry::where('status', 'new')->count(),
            'unread_messages' => ContactMessage::where('status', 'new')->count(),
        ];

        $recentEnquiries = Inquiry::with('variant')
            ->latest()
            ->limit(6)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentEnquiries' => $recentEnquiries,
        ]);
    }
}
