<?php

declare(strict_types=1);

namespace App\Services\DTO;

use App\Services\Helpers\SerializerTrait;

class EarthquakeDTO
{
    use SerializerTrait;
    
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly float $magnitude,
        public readonly string $place,
        public readonly \DateTimeImmutable $time,
    ) {}
}
