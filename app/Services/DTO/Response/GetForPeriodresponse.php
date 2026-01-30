<?php

declare(strict_types=1);

namespace App\Services\DTO\Response;

use App\Services\DTO\EarthquakeDTO;
use App\Services\DTO\Metadata;
use App\Services\Helpers\SerializerTrait;

class GetForPeriodresponse
{
    use SerializerTrait;
    
    /**
     * @param string $type
     * @param Metadata $metadata
     * @param EarthquakeDTO[] $earthquakes
     */
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
        public readonly ?Metadata $metadata = null,
        public readonly array $earthquakes = []
    ) {}
}
