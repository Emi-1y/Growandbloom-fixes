<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('service.index_title');
        $viewData['services'] = Service::where('active', true)->orderBy('id')->get();

        return view('services.index')->with('viewData', $viewData);
    }
}
