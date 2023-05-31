<?php

namespace App\Contracts;

use App\Exceptions\FetchHistoricalDataException;

/**
 * Interface HistoricalDataServiceInterface
 *
 * This interface defines the contract for a historical data service,
 * which is responsible for fetching historical stock data for a given symbol.
 */

interface HistoricalDataServiceInterface
{
    /**
     * Fetch historical data for the given symbol.
     *
     * @param string $symbol The symbol of the company for which to fetch historical data.
     * @return mixed The fetched historical data.
     *
     * @throws FetchHistoricalDataException If there is an error fetching the historical data.
     */
    public function fetchHistoricalData(string $symbol): mixed;
}
