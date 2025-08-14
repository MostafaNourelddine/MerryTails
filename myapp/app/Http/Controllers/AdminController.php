<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Item;

class AdminController extends Controller
{
    public function index()
    {
        // Get comprehensive statistics
        $stats = [
            'categories' => [
                'count'      => Category::count(),
                'with_items' => Category::has('items')->count(),
                'recent'     => Category::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'items'      => [
                'count'       => Item::count(),
                'on_sale'     => Item::where('sale', true)->count(),
                'recent'      => Item::where('created_at', '>=', now()->subDays(7))->count(),
                'total_value' => Item::sum('price'),
            ],
            'images'     => [
                'count'  => Image::count(),
                'recent' => Image::where('created_at', '>=', now()->subDays(7))->count(),
            ],
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
