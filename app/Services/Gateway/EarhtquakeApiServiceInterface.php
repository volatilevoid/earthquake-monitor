<?php

namespace App\Services\Gateway;

use App\Services\DTO\Request\GetForPeriodRequest;
use App\Services\DTO\Response\GetForPeriodresponse;

interface EarhtquakeApiServiceInterface
{
    public function getForPeriod(GetForPeriodRequest $request): GetForPeriodresponse;
}
