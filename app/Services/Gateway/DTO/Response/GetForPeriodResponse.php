<?php

declare(strict_types=1);

namespace App\Services\Gateway\DTO\Response;

use App\Services\DTO\EarthquakeDTO;
use App\Services\DTO\Metadata;
use App\Services\Helpers\SerializerTrait;

readonly class GetForPeriodResponse
{
    use SerializerTrait;

    /**
     * @param bool $success
     * @param string $message
     * @param Metadata|null $metadata
     * @param EarthquakeDTO[] $earthquakes
     */
    public function __construct(
        public bool $success,
        public string $message,
        public ?Metadata $metadata = null,
        public array $earthquakes = []
    ) {}
}
