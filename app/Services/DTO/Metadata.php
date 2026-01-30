<?php

declare(strict_types=1);

namespace App\Services\DTO;

use App\Services\Helpers\SerializerTrait;

class Metadata
{
    use SerializerTrait;

    public function __construct(
        public readonly \DateTimeImmutable $generated,
        public readonly string $url,
        public readonly string $title,
        public readonly int $status,
        public readonly string $api,
        public readonly int $count
    ) {}
}
