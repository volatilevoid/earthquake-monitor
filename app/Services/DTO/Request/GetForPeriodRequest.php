<?php

declare(strict_types=1);

namespace App\Services\DTO\Request;

class GetForPeriodRequest
{
    public function __construct(
        public readonly \DateTimeImmutable $from,
        public readonly \DateTimeImmutable $to,
    ) {}
}
