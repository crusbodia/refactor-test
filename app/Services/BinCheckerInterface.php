<?php

namespace App\Services;

use App\Bin;

interface BinCheckerInterface
{
    public function getDetails(string $bin): Bin;
}
