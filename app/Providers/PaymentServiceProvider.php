<?php

// Author: Emily Cardona Castañeda

namespace App\Providers;

use App\Interfaces\PaymentInterface;
use App\Utils\ChequePaymentService;
use App\Utils\TransferPaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentInterface::class, function ($app, array $params = []) {
            $driver = $params['driver'] ?? config('services.payment.driver', 'cheque');

            return match ($driver) {
                'transfer', 'nequi', 'card' => new TransferPaymentService,
                default => new ChequePaymentService,
            };
        });
    }
}
