<?php

declare (strict_types = 1);

namespace App\Services\Factory\Response;

use App\Services\DTO\Metadata;
use App\Services\Factory\EarthquakeDtoFactory;
use App\Services\Gateway\DTO\Response\GetForPeriodResponse;

class GetForPeriodResponseFactory
{
    public function __construct(
        private readonly EarthquakeDtoFactory $earthquakeDtoFactory
    ) {}

    public function fromApiResponse(array $apiResponse, bool $success = true, $message = ''): GetForPeriodResponse
    {
        $earthquakes = [];

        foreach ($apiResponse['features'] as $earthquakeArray) {
            $earthquakes[] = $this->earthquakeDtoFactory->fromArray($earthquakeArray);
        }

        return new GetForPeriodResponse(
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
