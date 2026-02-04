<?php

declare(strict_types=1);

namespace App\UseCase\ProcessEarthquakeData\Handler;

use App\Helper\CacheKeyHelper;
use App\Models\Earthquake;
use App\UseCase\ProcessEarthquakeData\Request\ProcessEarthquakeDataRequest;
use App\UseCase\ProcessEarthquakeData\Response\ProcessEarthquakeDataResponse;
use Illuminate\Support\Facades\Cache;

class PersistEarthquakeHandler extends AbstractHandler implements HandlerInterface
{
    public function handle(ProcessEarthquakeDataRequest $request): ProcessEarthquakeDataResponse
    {
        $haveNewEntries = false;
        $newEarthQuakesDTOs = [];

        foreach ($request->getEarthquakes() as $earthquakeDTO) {

            $isNew = is_null(Earthquake::where('external_id', $earthquakeDTO->id)->first());

            if ($isNew) {
                Earthquake::factory()->create([
                    'external_id' => $earthquakeDTO->id,
                    'magnitude' => $earthquakeDTO->magnitude,
                    'place' => $earthquakeDTO->place,
                    'occurred_at' => $earthquakeDTO->time
                ]);

                $newEarthQuakesDTOs[] = $earthquakeDTO;

                if (!$haveNewEntries) {
                    $haveNewEntries = true;
                }
            }
        }

        if (!$haveNewEntries) {
            return new ProcessEarthquakeDataResponse(
                true,
                'No new earthquake entries fetched',
            );
        }

        Cache::tags(CacheKeyHelper::EARTHQUAKES_TAG)->flush();

        $request->setEarthquakes($newEarthQuakesDTOs);

        return parent::handle($request);
    }
}
