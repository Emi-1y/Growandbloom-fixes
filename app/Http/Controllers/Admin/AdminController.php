<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('admin.dashboard_title');
        $viewData['subtitle'] = __('admin.dashboard_subtitle');
        $viewData['plantsCount'] = Plant::count();
        $viewData['categoriesCount'] = Category::count();
        $viewData['activePlantsCount'] = Plant::where('active', true)->count();
        $viewData['servicesCount'] = Service::where('active', true)->count();
        $viewData['ordersCount'] = Order::count();
        $viewData['pendingOrdersCount'] = Order::where('status', Order::STATUS_PENDING)->count();
        $viewData['usersCount'] = User::where('role', User::ROLE_USER)->count();
        $viewData['recentOrders'] = Order::with('user')->orderByDesc('id')->limit(5)->get();

        return view('admin.index')->with('viewData', $viewData);
    }
}
