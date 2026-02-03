<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Handler;

use App\Models\Config;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;

class CheckThresholdHandler extends AbstractHandler implements HandlerInterface
{
    public function handle(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse
    {
        $earthquakesOverThreshold = [];

        $minThreshold = Config::min('magnitude_threshold');

        foreach ($request->getEarthquakes() as $earthquakeDTO) {
            if ($earthquakeDTO->magnitude > $minThreshold) {
                $earthquakesOverThreshold[] = $earthquakeDTO;
            }
        }

        if (empty($earthquakesOverThreshold)) {
            return new ProcessEarthquakeDataResponse(
                true,
                'No earthquakes found with magnitude larger than threshold',
            );
        }

        $request->setEarthquakes($earthquakesOverThreshold);

        return parent::handle($request);
    }
}
