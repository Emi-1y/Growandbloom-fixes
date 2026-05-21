<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plant;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Grow and Bloom';
        $viewData['featuredPlants'] = Plant::with('category')
            ->where('active', true)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
        $viewData['categories'] = Category::orderBy('name')->get();

        return view('home.index')->with('viewData', $viewData);
    }
}
