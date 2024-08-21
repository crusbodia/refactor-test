<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\CommissionCalculatorService;
use App\Services\BinCheckerInterface;
use App\Services\ExchangeServiceInterface;
use App\Services\CommissionRateInterface;
use App\Transaction;
use App\Bin;
use Mockery;

class CommissionCalculatorServiceTest extends TestCase
{
    protected $binChecker;
    protected $exchangeRates;
    protected $commissionRate;

    protected function setUp(): void
    {
        $this->binChecker = Mockery::mock(BinCheckerInterface::class);
        $this->exchangeRates = Mockery::mock(ExchangeServiceInterface::class);
        $this->commissionRate = Mockery::mock(CommissionRateInterface::class);
    }

    public function testHandleMethodWhenTransactionExists(): void
    {
        $transactionData = '{"bin": "45417360", "amount": "1000.00", "currency": "EUR"}';
        $transaction = Transaction::fromJson($transactionData);

        $binData = new Bin(null, 'LT');
        $this->binChecker->shouldReceive('getDetails')->andReturn($binData);

        $this->exchangeRates->shouldReceive('convertToEur')->andReturn(1000);
        $this->commissionRate->shouldReceive('getCommissionRateByCountry')->andReturn(0.02);

        $service = new CommissionCalculatorService(
            $this->binChecker,
            $this->exchangeRates,
            $this->commissionRate
        );

        $filepath = tmpfile();
        fwrite($filepath, $transactionData);
        fseek($filepath, 0);  // Go to the beginning otherwise it would read an empty file

        $result = $service->handle(stream_get_meta_data($filepath)['uri']);
        fclose($filepath);

        $this->assertEquals([["error" => false, "data" => 20.0]], $result);
    }

    public function testHandleMethodWhenTransactionDoesNotExist(): void
    {
        $filepath = "non-existing-filepath";

        $service = new CommissionCalculatorService(
            $this->binChecker,
            $this->exchangeRates,
            $this->commissionRate
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File does not exist');

        $service->handle($filepath);
    }
}
