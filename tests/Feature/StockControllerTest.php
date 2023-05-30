<?php

namespace Tests\Feature;

use Tests\TestCase;
use Psr\Log\NullLogger;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\StockController;
use App\Http\Requests\HistoricalDataRequest;
use App\Contracts\CompanyDataServiceInterface;
use App\Contracts\HistoricalDataServiceInterface;
use App\Contracts\StockDataEmailServiceInterface;

class StockControllerTest extends TestCase
{
    /**
     * A StockController test to test getHistoricalData method
    */
    public function testGetHistoricalData()
    {
        // Create a mock of the HistoricalDataServiceInterface
        $historicalDataServiceMock = $this->createMock(HistoricalDataServiceInterface::class);

        $historicalData = (object) [
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

        // Set up the mock's behavior for the fetchHistoricalData method
        $symbol = 'AAIT';
        $historicalDataServiceMock->expects($this->once())
        ->method('fetchHistoricalData')
        ->with($symbol)
        ->willReturn($historicalData);

        // Create a mock of the CompanyDataServiceInterface
        $companyDataServiceMock = $this->createMock(CompanyDataServiceInterface::class);

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

        // Set up the mock's behavior for the getCompanyData method
        $companyDataServiceMock->expects($this->once())
            ->method('getCompanyData')
            ->willReturn($companyData);

        // Create a mock of the StockDataEmailServiceInterface
        $stockEmailServiceMock = $this->createMock(StockDataEmailServiceInterface::class);

        // Create an instance of the StockController with the mocks
        $stockController = new StockController(
            $historicalDataServiceMock,
            $companyDataServiceMock,
            $stockEmailServiceMock,
            new NullLogger()
        );

        $data = [
            'company_symbol' => 'AAIT',
            'start_date' => '2023-05-01',
            'end_date' => '2023-05-30',
            'email' => 'test@example.com',
        ];
        $requestData = new HistoricalDataRequest($data);

        // Call the method being tested
        $response = $stockController->getHistoricalData($requestData);

        $this->assertInstanceOf(View::class, $response);
        $this->assertArrayHasKey('symbol', $response->getData());
        $this->assertArrayHasKey('startDate', $response->getData());
        $this->assertArrayHasKey('endDate', $response->getData());
        $this->assertArrayHasKey('historicalData', $response->getData());
        $this->assertEquals((array) $historicalData->prices, (array) $response->getData()['historicalData']);
    }


}
