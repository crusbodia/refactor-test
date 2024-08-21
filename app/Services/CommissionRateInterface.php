<?php

namespace App\Services;

interface CommissionRateInterface
{
    public function getCommissionRateByCountry($countryCode): float;
}
