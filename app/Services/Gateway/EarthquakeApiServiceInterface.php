<?php

namespace App\Services\Gateway;

use App\Services\Gateway\DTO\Request\GetForPeriodRequest;
use App\Services\Gateway\DTO\Response\GetForPeriodResponse;

interface EarthquakeApiServiceInterface
{
    public function getForPeriod(GetForPeriodRequest $request): GetForPeriodResponse;
}
