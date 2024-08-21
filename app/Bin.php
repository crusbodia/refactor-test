<?php

namespace App;

readonly class Bin
{
    public function __construct(
        private ?string $brand,
        private string  $countryAlpha2,
    ) {}

    public function getBrand(): ?string
    {
        return $this?->brand;
    }

    public function getCountryAlpha2(): string
    {
        return $this->countryAlpha2;
    }
}
