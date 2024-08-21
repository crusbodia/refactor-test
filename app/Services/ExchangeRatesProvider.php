<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    const API_URL = 'https://api.exchangeratesapi.io/latest';

    public function getRates(): ?array
    {
        $data = Http::withQueryParameters([
            'access_key' => config('services.exchange_rate.key'),
        ])->get(static::API_URL)->json();

        return Arr::get($data, 'rates');
    }
}
