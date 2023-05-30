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

