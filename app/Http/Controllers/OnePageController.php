<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ShowroomModel;
use App\Models\Testimonial;

class OnePageController extends Controller
{
    /**
     * The single-page ("onepage") experience: hero, shop catalog (infinite
     * scroll via the ProductGrid Livewire component), 3D showroom teaser,
     * about and contact — all in one continuously scrollable view.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $showroomModels = ShowroomModel::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredShowroomModel = $showroomModels->firstWhere('is_featured', true)
            ?? $showroomModels->first();

        $stats = [
            ['value' => '1,000+', 'label' => 'Offices Served'],
            ['value' => Product::where('status', 'active')->count() > 0
                ? Product::where('status', 'active')->count().'+'
                : '500+', 'label' => 'Products'],
            ['value' => '36', 'label' => 'States Covered'],
            ['value' => '5 Star', 'label' => 'Average Rating'],
        ];

        return view('onepage', compact(
            'categories',
            'testimonials',
            'showroomModels',
            'featuredShowroomModel',
            'stats'
        ));
    }
}
