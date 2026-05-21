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
    private const API_URL = 'http://34.67.107.26/api/pieces';

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('allied.title');

        try {
            $response = Http::timeout(5)->get(self::API_URL);
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
