<?php

namespace App\Providers;

use App\Services\BinChecker;
use App\Services\BinCheckerInterface;
use App\Services\CommissionRate;
use App\Services\CommissionRateInterface;
use App\Services\ExchangeService;
use App\Services\ExchangeServiceInterface;
use App\Services\ExchangeRatesProvider;
use App\Services\ExchangeRatesProviderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(BinCheckerInterface::class, BinChecker::class);
        $this->app->singleton(ExchangeServiceInterface::class, ExchangeService::class);
        $this->app->singleton(CommissionRateInterface::class, CommissionRate::class);
        $this->app->singleton(ExchangeRatesProviderInterface::class, ExchangeRatesProvider::class);
    }
}
