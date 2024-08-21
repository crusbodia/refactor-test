<?php

namespace Tests\Unit;

use App\Services\BinChecker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BinCheckerServiceTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     */
    public function testGetBinTestSuccess(): void
    {
        Http::fake([
            'https://lookup.binlist.net/*' => Http::response([
                "number" => [],
                "scheme" => "visa",
                "type" => "debit",
                "brand" => "Visa Classic/Dankort",
                "country" => [
                    "numeric" => "208",
                    "alpha2" => "JP",
                    "name" => "Denmark",
                    "emoji" => "🇩🇰",
                    "currency" => "DKK",
                    "latitude" => 56,
                    "longitude" => 10
                ],
                "bank" => [
                    "name" => "Jyske Bank A/S"
                ]
            ], 200),
        ]);

        $service = new BinChecker();
        $bin = $service->getDetails('45717360');

        $this->assertEquals($bin->getCountryAlpha2(), 'JP');
    }

    public function testGetBinFail(): void
    {
        Http::fake([
            'https://lookup.binlist.net/*' => Http::response(null, 500),
        ]);
        $this->expectException(\Exception::class);

        $service = new BinChecker();
        $bin = $service->getDetails('45717360');

        dd($bin);
    }
}
