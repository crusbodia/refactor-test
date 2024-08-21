<?php

namespace App\Services;

use App\Bin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class BinChecker implements BinCheckerInterface
{
    const API_URL = 'https://lookup.binlist.net';

    public function getDetails(string $bin): Bin
    {
        $data = Http::withUrlParameters([
            'bin' => $bin
        ])->get(static::API_URL . '/{bin}')->json();

        $alpha2 = Arr::get($data, 'country.alpha2');

        if (!$alpha2) {
            throw new \Exception('Cannot receive alpha2');
        }

        return new Bin(
            Arr::get($data, 'brand'),
            $alpha2,
        );
    }
}
