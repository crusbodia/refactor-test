<?php

namespace App\Services;

use App\Enums\EuCountry;

class CommissionRate implements CommissionRateInterface
{
    public function getCommissionRateByCountry($countryCode): float
    {
        return EuCountry::isEu($countryCode) ? 0.01 : 0.02;
    }
}
