<?php

// Author: Emily Cardona Castañeda

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    private const API_URL = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/cop.json';

    private const CACHE_KEY = 'exchange_cop_usd';

    private const CACHE_TTL = 21600;

    public function getUsdRate(): float
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            try {
                $response = Http::timeout(5)->get(self::API_URL);

                if ($response->successful()) {
                    return (float) ($response->json('cop.usd') ?? 0);
                }
            } catch (ConnectionException $e) {
                Log::warning('CurrencyService: API no disponible — '.$e->getMessage());
            }

            return 0.0;
        });
    }
}
