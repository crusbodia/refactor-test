<?php

namespace App\Services;

use App\Transaction;
use Illuminate\Support\Facades\File;

readonly class CommissionCalculatorService
{
    public function __construct(
        private BinCheckerInterface $binChecker,
        private ExchangeServiceInterface $exchangeRates,
        private CommissionRateInterface $commissionRate,
    ) {}

    /**
     * @throws \Exception
     */
    public function handle($filepath)
    {
        if (!File::exists($filepath)) {
            throw new \Exception("File does not exist");
        }

        $content = File::get($filepath);
        $lines = explode("\n", trim($content));
        $result = [];

        foreach ($lines as $line) {
            if ($line === '') {
                continue;
            }
            try {
                $transaction = Transaction::fromJson($line);

                $result[] = [
                    'error' => false,
                    'data' => $this->getCommission($transaction)
                ];
            } catch (\Exception $e) {
                $result[] = ['error' => true, 'data' => $e->getMessage()];
            }
        }

        return $result;
    }

    public function getCommission(Transaction $transaction): float
    {
        $bin = $this->binChecker->getDetails($transaction->getBin());
        $commissionRate = $this->commissionRate->getCommissionRateByCountry($bin->getCountryAlpha2());
        $amount = $this->exchangeRates->convertToEur(
            $transaction->getAmount(),
            $transaction->getCurrency()
        );

        return $amount * $commissionRate;
    }
}
