<?php

declare(strict_types=1);

namespace App\Services\Factory;

use App\Services\DTO\EarthquakeDTO;

class EarthquakeDtoFactory
{
    public function fromArray(array $earthquakeArray): EarthquakeDto
    {
        return new EarthquakeDto(
            $earthquakeArray['id'],
            $earthquakeArray['properties']['title'],
            $earthquakeArray['properties']['mag'] ?? 0,
            $earthquakeArray['properties']['place'],
            (new \DateTimeImmutable())->setTimestamp((int)($earthquakeArray['properties']['time'] / 1000)),
            $earthquakeArray['properties']['url']
        );
    }
}
