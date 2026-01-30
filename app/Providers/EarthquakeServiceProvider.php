<?php

namespace App\Providers;

use App\Services\Factory\EarthquakeDtoFactory;
use App\Services\Gateway\EarhtquakeApiServiceInterface;
use App\Services\Gateway\UsgsEarhtquakeApiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class EarthquakeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EarhtquakeApiServiceInterface::class, function (Application $app) {
            return new UsgsEarhtquakeApiService(
                $app->make(EarthquakeDtoFactory::class),
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
