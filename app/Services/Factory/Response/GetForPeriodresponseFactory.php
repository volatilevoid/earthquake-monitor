<?php

declare (strict_types = 1);

namespace App\Services\Factory\Response;

use App\Services\DTO\EarthquakeDTO;
use App\Services\DTO\Metadata;
use App\Services\DTO\Response\GetForPeriodresponse;
use App\Services\Factory\EarthquakeDtoFactory;

class GetForPeriodresponseFactory
{
    public function __construct(
        private readonly EarthquakeDtoFactory $earthquakeDtoFactory
    ) {}

    public function fromApiResponse(array $apiResponse, bool $success = true, $message = ''): GetForPeriodresponse
    {
        $earthquakes = [];

        foreach ($apiResponse['features'] as $earthquakeArray) {
            $earthquakes[] = $this->earthquakeDtoFactory->fromArray($earthquakeArray);
        }

        return new GetForPeriodresponse(
            $success,
            $message,
            new Metadata(
                (new \DateTimeImmutable())->setTimestamp($apiResponse['metadata']['generated']),
                $apiResponse['metadata']['url'],
                $apiResponse['metadata']['title'],
                $apiResponse['metadata']['status'],
                $apiResponse['metadata']['api'],
                $apiResponse['metadata']['count'],
            ),
            $earthquakes
        );
    }
}
