<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Handler;

use App\Models\Earthquake;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;

class PersistEarthquakeHandler extends AbstractHandler implements HandlerInterface
{
    public function handle(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse
    {
        foreach ($request->getEarthquakes() as $earthquakeDTO) {
            Earthquake::factory()->create([
                'external_id' => $earthquakeDTO->id,
                'magnitude' => $earthquakeDTO->magnitude,
                'place' => $earthquakeDTO->place,
                'occurred_at' => $earthquakeDTO->time
            ]);
        }

        // TODO logging

        return parent::handle($request);
    }
}
