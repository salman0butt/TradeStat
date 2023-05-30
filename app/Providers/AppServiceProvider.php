<?php

namespace App\Providers;

use App\Http\Clients\HttpClient;
use App\Services\CompanyDataService;
use App\Services\HistoricalDataService;
use App\Services\StockDataEmailService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\CompanyDataServiceInterface;
use App\Contracts\HistoricalDataServiceInterface;
use App\Contracts\StockDataEmailServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $httpClient = new HttpClient();

        $this->app->bind(HistoricalDataServiceInterface::class, function ($app) use($httpClient) {
            $apiKey = config('global.RAPID_API_KEY');
            $apiUrl = config('global.RAPID_API_URL');
            return new HistoricalDataService($apiKey, $apiUrl, $httpClient);
        });

        $this->app->bind(CompanyDataServiceInterface::class, function($app) use($httpClient) {
            $cacheDuration = config('global.COMPANY_DATA_DURATION');
            $apiUrl = config('global.RAPID_API_URL');
            return new CompanyDataService($httpClient, $cacheDuration, $apiUrl);
        });

        $this->app->bind(StockDataEmailServiceInterface::class, StockDataEmailService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
