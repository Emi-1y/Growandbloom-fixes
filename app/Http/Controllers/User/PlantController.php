<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlantController extends Controller
{
    public function __construct(private readonly CurrencyService $currencyService) {}

    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Plant::query()
            ->with('category')
            ->where('active', true);

        if (! empty($search)) {
            $query->where('name', 'like', '%'.$search.'%');
        }

        $plants = $query
            ->orderByDesc('id')
            ->paginate(12)
            ->appends($request->query());

        $viewData = [];
        $viewData['title'] = __('plant.index_title');
        $viewData['plants'] = $plants;
        $viewData['showPagination'] = true;
        $viewData['search'] = $search;
        $viewData['usdRate'] = $this->currencyService->getUsdRate();

        return view('plants.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $plant = Plant::with('category')->where('active', true)->findOrFail($id);

        $viewData = [];
        $viewData['title'] = $plant->getName();
        $viewData['plant'] = $plant;
        $viewData['usdRate'] = $this->currencyService->getUsdRate();

        return view('plants.show')->with('viewData', $viewData);
    }
}
