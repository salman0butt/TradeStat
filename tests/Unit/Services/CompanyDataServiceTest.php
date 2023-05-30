<?php

use App\Http\Clients\HttpClientInterface;
use App\Services\CompanyDataService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;

class CompanyDataServiceTest extends TestCase
{

    protected $apiUrl = 'https://example.com/api';
    protected $cacheDuration = 60;

    public function testGetCompanyData()
    {
        // Create a mock for the HttpClientInterface
        $httpClient = $this->createMock(HttpClientInterface::class);

        //Company Data
        $companyData = [
            [
                "Company Name" => "iShares MSCI All Country Asia Information Technology Index Fund",
                "Financial Status" => "N",
                "Market Category" => "G",
                "Round Lot Size" => 100.0,
                "Security Name" => "iShares MSCI All Country Asia Information Technology Index Fund",
                "Symbol" => "AAIT",
                "Test Issue" => "N",
            ],
        ];

        // Create a mock response
        $response = $this->createMock(Response::class);
        $response->method('failed')->willReturn(false);
        $response->method('json')->willReturn(['company_data' => $companyData]);

        // Set up the expectations for the HttpClientInterface mock
        $httpClient->expects($this->once())
            ->method('get')
            ->with($this->equalTo($this->apiUrl))
            ->willReturn($response);

        // Disable cache by skipping the Cache::remember method
        Cache::shouldReceive('remember')->andReturnUsing(function ($key, $minutes, $callback) {
            return $callback();
        });

        // Create an instance of the CompanyDataService using the mock HttpClientInterface
        $service = new CompanyDataService($httpClient, $this->cacheDuration, $this->apiUrl);

        // Call the getCompanyData method
        $result = $service->getCompanyData();

        // Assert that the returned data is the same as the response's json
        $this->assertEquals($response->json(), $result);
    }
}
