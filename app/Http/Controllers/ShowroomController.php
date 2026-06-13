<?php

namespace App\Http\Controllers;

use App\Models\ShowroomModel;

class ShowroomController extends Controller
{
    public function index()
    {
        $models = ShowroomModel::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featured = ShowroomModel::where('is_active', true)
            ->where('is_featured', true)
            ->first();

        return view('showroom.index', compact('models', 'featured'));
    }
}
