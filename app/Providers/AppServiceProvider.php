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
        $this->app->bind(HistoricalDataServiceInterface::class, function ($app) {
            $apiKey = config('global.RAPID_API_KEY');
            $apiUrl = config('global.RAPID_API_URL');
            $httpClient = $app->make(HttpClient::class);
            return new HistoricalDataService($apiKey, $apiUrl, $httpClient);
        });

        $this->app->bind(CompanyDataServiceInterface::class, function($app) {
            $cacheDuration = config('global.COMPANY_DATA_DURATION');
            $apiUrl = config('global.COMPANY_DATA_URL');
            $httpClient = $app->make(HttpClient::class);
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
