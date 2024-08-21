<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ExchangeService implements ExchangeServiceInterface
{
    const DEFAULT_CURRENCY = 'EUR';

    private ?array $rates;

    public function __construct(ExchangeRatesProviderInterface $provider)
    {
        $this->rates = $provider->getRates();
    }

    /**
     * @throws \Exception
     */
    public function getRates(): array
    {
        if (!$this->rates) {
            throw new \Exception('Fetching rates failed');
        }

        return $this->rates;
    }

    /**
     * @throws \Exception
     */
    public function getExchangeRate(string $currency): ?float
    {
        return Arr::get($this->getRates(), $currency);
    }

    public function convertToEur(float $value, string $currency): float
    {
        if (!$this->getExchangeRate($currency)) {
            return $value;
        }

        if (Str::upper($currency) === self::DEFAULT_CURRENCY) {
            return $value;
        }

        return $value / $this->getExchangeRate($currency);
    }
}
