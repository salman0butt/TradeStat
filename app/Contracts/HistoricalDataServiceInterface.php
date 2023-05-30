<?php

namespace App\Contracts;

interface HistoricalDataServiceInterface
{
    public function fetchHistoricalData(string $symbol): mixed;
}
