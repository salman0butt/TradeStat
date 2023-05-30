<?php

declare (strict_types = 1);

/**
 * The HistoricalDataService class fetches historical data for a given symbol from an external API.
 * It encapsulates the logic for making the API request, handling the response, and extracting the relevant data.
 */

namespace App\Services;

use App\Contracts\HistoricalDataServiceInterface;
use App\Http\Clients\HttpClientInterface;

use App\Exceptions\FetchHistoricalDataException;

use Exception;
use Illuminate\Support\Facades\Http;

class HistoricalDataService implements HistoricalDataServiceInterface
{
    /**
     * Http Client
     *
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * API key for accessing the external API.
     *
     * @var string
     */
    private string $apiKey;

    /**
     * URL for the external API.
     *
     * @var string
     */
    private string $apiUrl;

    /**
     * Create a new HistoricalDataService instance.
     *
     * @param string $apiKey
     * @param string $apiUrl
     */
    public function __construct(string $apiKey, string $apiUrl, HttpClientInterface $httpClient)
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
        $this->httpClient = $httpClient;
    }

    /**
     * Fetch historical data for the given symbol from the external API.
     *
     * @param string $symbol
     * @return mixed
     * @throws Exception
     */
    public function fetchHistoricalData(string $symbol): mixed
    {
        $headers = [
            'X-RapidAPI-Key' => $this->apiKey,
            'X-RapidAPI-Host' => $this->getApiHost(),
        ];
        $params = [
            'symbol' => $symbol,
            'region' => 'US'
        ];

        $response = $this->httpClient->get($this->apiUrl, $params, $headers);

        if ($response->failed()) {
            throw new FetchHistoricalDataException('Failed to fetch historical data. API response: ' . $response->body());
        }

        return $this->extractHistoricalData($response);
    }

    /**
     * Extract historical data from the API response.
     *
     * @param mixed $response
     * @return mixed
     */
    private function extractHistoricalData($response): mixed
    {
        $historicalData = json_decode($response->body());
        return $historicalData;
    }

    /**
     * Get the API host.
     *
     * @return string
     */
    private function getApiHost(): string
    {
        // Implement logic to retrieve the API host based on environment or configuration
        return 'yh-finance.p.rapidapi.com';
    }
}
