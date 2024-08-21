<?php

namespace App\Services;

interface ExchangeServiceInterface
{
    public function getRates(): array;

    public function getExchangeRate(string $currency): ?float;

    public function convertToEur(float $value, string $currency): float;
}
