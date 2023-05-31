<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;
use App\Http\Requests\HistoricalDataRequest;
use App\Exceptions\FetchCompanyDataException;
use App\Contracts\CompanyDataServiceInterface;
use App\Exceptions\FetchHistoricalDataException;
use App\Contracts\HistoricalDataServiceInterface;
use App\Contracts\StockDataEmailServiceInterface;
use App\Exceptions\InvalidCompanySymbolException;

class StockController extends Controller
{

    private HistoricalDataServiceInterface $historicalDataService;

    private CompanyDataServiceInterface $companyDataService;

    private StockDataEmailServiceInterface $stockEmailService;

    private LoggerInterface $logger;

    /**
     * StockController constructor.
     *
     * @param HistoricalDataServiceInterface $historicalDataService
     * @param CompanyDataServiceInterface $companyDataService
     * @param StockDataEmailServiceInterface $stockEmailService
     * @param LoggerInterface $logger
     */
    public function __construct(
        HistoricalDataServiceInterface $historicalDataService,
        CompanyDataServiceInterface $companyDataService,
        StockDataEmailServiceInterface $stockEmailService,
        LoggerInterface $logger
    ) {
        $this->historicalDataService = $historicalDataService;
        $this->companyDataService = $companyDataService;
        $this->stockEmailService = $stockEmailService;
        $this->logger = $logger;
    }

    /**
     * Show the stock form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('stocks.stock-form');
    }

    /**
     * Get historical data and display it in a table.
     *
     * @param HistoricalDataRequest $request
     * @return mixed
     */
    public function getHistoricalData(HistoricalDataRequest $request): mixed
    {
        try {
            $symbol = $request->input('company_symbol');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $email = $request->input('email');
            $companyName = $this->getCompanyName($symbol);

            // if Company Not Found It mean Symbol is Invalid
            if (!$companyName) {
                throw new InvalidCompanySymbolException();
            }

            // Fetch filtered Historical Data
            $prices = $this->filterHistoricalData($symbol, $startDate, $endDate);

            $data = [
                'symbol' => $symbol,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'companyName' => $companyName,
            ];

            // Send Email
            $this->sendStockDataEmail($email, $data);

            // Display the historical quotes in a table
            return view('stocks.stock-data', [
                'symbol' => $symbol,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'historicalData' => $prices,
            ]);

        } catch (InvalidCompanySymbolException $exp) {
            $errorMessage = 'Invalid company symbol. Please provide a valid symbol.';
            $this->logger->error($exp->getMessage());
            return back()->with('error', $errorMessage);
        } catch (FetchCompanyDataException $exp) {
            $errorMessage = 'Failed to fetch Company data. Please try again later.';
            $this->logger->error($exp->getMessage());
            return back()->with('error', $errorMessage);
        } catch (FetchHistoricalDataException $exp) {
            $errorMessage = 'Failed to fetch historical data. Please try again later.';
            $this->logger->error($exp->getMessage());
            return back()->with('error', $errorMessage);
        } catch (Exception $exp) {
            $errorMessage = 'Something went wrong. Please try again.';
            $this->logger->error($exp->getMessage());
            return back()->with('error', $exp->getMessage());
        }

    }

    /**
     * Get the company name for the given symbol.
     *
     * @param string $symbol
     * @return string
     */
    private function getCompanyName(string $symbol): string
    {
        // Fetch Comapny Data via historicalDataService
        $companyData = $this->companyDataService->getCompanyData();
        foreach ($companyData as $company) {
            if ($company['Symbol'] === $symbol) {
                return $company['Company Name'];
            }
        }

        return '';
    }

    /**
     * Filter the historical data based on the symbol, start date, and end date.
     *
     * @param string $symbol
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    private function filterHistoricalData(string $symbol,string $startDate,string $endDate): array
    {
        // fetch historical data via historicalDataService
        $historicalData = $this->historicalDataService->fetchHistoricalData($symbol);

        $prices = [];
        if ($historicalData->prices) {
            foreach ($historicalData->prices as $item) {
                $itemDateTime = Carbon::parse($item->date);

                // Compare the date: should be between startDate and endDate
                $startDateCheck = Carbon::parse($startDate)->startOfDay();
                $endDateCheck = Carbon::parse($endDate)->endOfDay();

                if ($itemDateTime->between($startDateCheck, $endDateCheck)) {
                    $prices[] = $item;
                }
            }
        }
        return $prices;
    }

    /**
     * Send the stock data email.
     *
     * @param string $email
     * @param array $data
     */
    private function sendStockDataEmail(string $email, array $data): void
    {
        // send email via stockEmailService
        $this->stockEmailService->sendEmail($email, $data);
    }
}
