<?php

namespace App\Services;

interface ExchangeRatesProviderInterface
{
    public function getRates(): ?array;
}
