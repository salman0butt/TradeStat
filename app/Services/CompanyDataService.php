<?php

declare (strict_types = 1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Http\Clients\HttpClientInterface;
use App\Exceptions\FetchCompanyDataException;
use App\Contracts\CompanyDataServiceInterface;

class CompanyDataService implements CompanyDataServiceInterface
{

    private HttpClientInterface $httpClient;

    private int $cacheDuration;
    private string $apiUrl;

    /**
     * CompanyDataService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client for making API requests.
     * @param int $cacheDuration The duration in seconds to cache the company data.
     * @param string $apiUrl The URL of the API endpoint for fetching the company data.
     */
    public function __construct(
        HttpClientInterface $httpClient,
        int $cacheDuration,
        string $apiUrl
    )
    {
        $this->httpClient = $httpClient;
        $this->cacheDuration = $cacheDuration;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Get company data.
     *
     * @return array The fetched company data.
     * @throws FetchCompanyDataException if there is an error fetching the company data.
     */
    public function getCompanyData()
    {
        return Cache::remember('company_data', $this->cacheDuration, function () {
            $response = $this->httpClient->get($this->apiUrl);

            if ($response->failed()) {
                throw new FetchCompanyDataException('Failed to fetch company data.');
            }

            return $response->json();
        });
    }
}

