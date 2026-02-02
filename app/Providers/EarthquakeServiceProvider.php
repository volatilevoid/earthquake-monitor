<?php

namespace App\Providers;

use App\Services\Factory\Response\GetForPeriodresponseFactory;
use App\Services\Gateway\EarthquakeApiServiceInterface;
use App\Services\Gateway\UsgsEarthquakeApiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class EarthquakeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EarthquakeApiServiceInterface::class, function (Application $app) {
            return new UsgsEarthquakeApiService(
                $app->make(GetForPeriodresponseFactory::class),
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
