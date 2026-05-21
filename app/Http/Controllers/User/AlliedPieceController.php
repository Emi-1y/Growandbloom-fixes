<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AlliedPieceController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('allied.title');

        try {
            $response = Http::timeout(5)->get(config('services.allied.api_url'));
            $viewData['pieces'] = $response->successful() ? $response->json() : [];
            $viewData['error'] = $response->successful() ? null : __('allied.error_fetch');
        } catch (ConnectionException $e) {
            Log::warning('AlliedPieceController: API no disponible — '.$e->getMessage());
            $viewData['pieces'] = [];
            $viewData['error'] = __('allied.error_connection');
        }

        return view('allied-piece.index')->with('viewData', $viewData);
    }
}
