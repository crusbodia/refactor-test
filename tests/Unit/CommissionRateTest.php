<?php

namespace Tests\Unit;

use App\Services\CommissionRate;
use PHPUnit\Framework\TestCase;

class CommissionRateTest extends TestCase
{

    public function testEuCountry(): void
    {
        $commissionRate = new CommissionRate();
        $commissionRateVal = $commissionRate->getCommissionRateByCountry('AT');
        $this->assertEquals($commissionRateVal, 0.01);
    }

    public function testNonEuCountry(): void
    {
        $commissionRate = new CommissionRate();
        $commissionRateVal = $commissionRate->getCommissionRateByCountry('JP');
        $this->assertEquals($commissionRateVal, 0.02);
    }

    public function testRandomString(): void
    {
        $commissionRate = new CommissionRate();
        $commissionRateVal = $commissionRate->getCommissionRateByCountry('21456768776345');
        $this->assertEquals($commissionRateVal, 0.02);
    }
}
