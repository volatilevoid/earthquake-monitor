<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Handler;

use App\Helper\CacheKeyHelper;
use App\Mail\EarthquakeThresholdExceeded;
use App\Models\User;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class NotifyUsersHandler extends AbstractHandler implements HandlerInterface
{
    public function handle(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse
    {

        $users = User::with('config')->get();

        foreach ($users as $user) {
            $earthquakesExceedUserThreshold = [];

            foreach ($request->getEarthquakes() as $earthquakeDTO) {
                if ($earthquakeDTO->magnitude > $user->config->magnitude) {
                    $earthquakesExceedUserThreshold[] = $earthquakeDTO;
                }
            }

            if (!empty($earthquakesExceedUserThreshold)) {
                Mail::to($user)->send(
                    new EarthquakeThresholdExceeded(
                        $earthquakesExceedUserThreshold,
                        $user
                    )
                );
            }

            Cache::delete(CacheKeyHelper::getEarthquakesForUser($user));
        }

        Cache::delete(CacheKeyHelper::getEarthquakesCacheKey());

        return new ProcessEarthquakeDataResponse(
            true,
            '',
            $request->getEarthquakes()
        );
    }
}
