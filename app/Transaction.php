<?php

namespace App;

readonly class Transaction
{
    public function __construct(
        private string $bin,
        private float  $amount,
        private string $currency
    ) {}

    public function getBin(): string {
        return $this->bin;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getCurrency(): string {
        return $this->currency;
    }

    public static function fromJson(string $json): Transaction {
        $data = json_decode($json);

        return new Transaction(
            $data->bin,
            $data->amount,
            $data->currency,
        );
    }
}
