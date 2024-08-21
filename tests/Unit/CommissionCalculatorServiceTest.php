<?php

namespace Tests\Unit;

use App\Services\BinChecker;
use App\Services\CommissionCalculatorService;
use App\Services\CommissionRate;
use App\Services\ExchangeService;
use App\Transaction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CommissionCalculatorServiceTest extends TestCase
{
    public function testCalculateUsdCommissionRate()
    {
        Http::fake([
            'https://api.exchangeratesapi.io/latest' => Http::response([
                "success" => true,
                "rates" => [
                    "USD" => 1.112805,
                ],
            ]),
        ]);
        Http::fake([
            'https://lookup.binlist.net/*' => Http::response([
                "country" => [
                    "alpha2" => "LT",
                ]
            ], 200),
        ]);

        $service = new CommissionCalculatorService(
            App::make(BinChecker::class),
            App::make(ExchangeService::class),
            App::make(CommissionRate::class),
        );

        $transaction = new Transaction('516793', 50.00, 'USD');

        $commission = $service->getCommission($transaction);
        $this->assertEquals(round($commission, 2), 0.45);
    }

    public function testCalculateNonEuCommissionRate()
    {
        Http::fake([
            'https://api.exchangeratesapi.io/latest' => Http::response([
                "success" => true,
                "rates" => [
                    "USD" => 161.498651,
                ],
            ]),
        ]);
        Http::fake([
            'https://lookup.binlist.net/*' => Http::response([
                "country" => [
                    "alpha2" => "LT",
                ]
            ], 200),
        ]);

        $service = new CommissionCalculatorService(
            App::make(BinChecker::class),
            App::make(ExchangeService::class),
            App::make(CommissionRate::class),
        );

        $transaction = new Transaction('45417360', 10000.00, 'JPY');

        $commission = $service->getCommission($transaction);
        $this->assertEquals(round($commission, 2), 0.62);
    }

    public function testCalculateEURCommissionRate()
    {
        Http::fake([
            'https://api.exchangeratesapi.io/latest' => Http::response([
                "success" => true,
                "rates" => [
                    "EUR" => 1,
                ],
            ]),
        ]);
        Http::fake([
            'https://lookup.binlist.net/*' => Http::response([
                "country" => [
                    "alpha2" => "LT",
                ]
            ], 200),
        ]);

        $service = new CommissionCalculatorService(
            App::make(BinChecker::class),
            App::make(ExchangeService::class),
            App::make(CommissionRate::class),
        );

        $transaction = new Transaction('45717360', 100.00, 'EUR');

        $commission = $service->getCommission($transaction);
        $this->assertEquals(round($commission, 2), 1);
    }
}
