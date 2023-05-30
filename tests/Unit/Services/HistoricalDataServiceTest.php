<?php

namespace Tests\Unit\Services;

use App\Services\HistoricalDataService;
use App\Http\Clients\HttpClientInterface;
use App\Exceptions\FetchHistoricalDataException;
use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;

class HistoricalDataServiceTest extends TestCase
{
    private HistoricalDataService $historicalDataService;
    private HttpClientInterface $httpClient;

    private $apiUrl = 'https://example.com/api';
    private $apiKey = 'your-api-key';

    protected function setUp(): void
    {
        parent::setUp();

        // Create mock instances of the dependencies
        $this->httpClient = $this->createMock(HttpClientInterface::class);

        // Create an instance of the HistoricalDataService with the mock dependencies
        $this->historicalDataService = new HistoricalDataService($this->apiKey, $this->apiUrl, $this->httpClient);
    }

    public function testFetchHistoricalDataReturnsExpectedData()
    {
        // Arrange
        $symbol = 'AAIT';
        $expectedData = (object) [
            'prices' => [
                (object) [
                    "date" => 1685107800,
                    "open" => 173.32000732422,
                    "high" => 175.77000427246,
                    "low" => 173.11000061035,
                    "close" => 175.42999267578,
                    "volume" => 54794100,
                    "adjclose" => 175.42999267578,
                ],
                (object) [
                    "date" => 1685107800,
                    "open" => 172.41000366211,
                    "high" => 173.89999389648,
                    "low" => 171.69000244141,
                    "close" => 172.99000549316,
                    "volume" => 56058300,
                    "adjclose" => 172.99000549316,
                ],
            ]
        ];

        // Set up the mock HTTP client to return the expected data
        $response = $this->createMock(Response::class);
        $response->method('failed')->willReturn(false);
        $response->method('body')->willReturn(json_encode($expectedData));
        $this->httpClient->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo($this->apiUrl),
                $this->callback(function ($params) use ($symbol) {
                    return isset($params['symbol']) && $params['symbol'] === $symbol;
                }),
                $this->anything()
            )
            ->willReturn($response);

        // Act
        $actualData = $this->historicalDataService->fetchHistoricalData($symbol);

        // Assert
        $this->assertEquals($expectedData, $actualData);
    }


    public function testFetchHistoricalDataThrowsExceptionOnFailedRequest()
    {
        // Arrange
        $symbol = 'AAIT';

        // Set up the mock HTTP client to return a failed response
        $response = $this->createMock(Response::class);
        $response->method('failed')->willReturn(true);
        $response->method('body')->willReturn('API error message');
        $this->httpClient->expects($this->once())
            ->method('get')
            ->willReturn($response);

        // Expect an exception of the specified type to be thrown
        $this->expectException(FetchHistoricalDataException::class);
        $this->expectExceptionMessage('Failed to fetch historical data. API response: API error message');

        // Act
        $this->historicalDataService->fetchHistoricalData($symbol);
    }
}
