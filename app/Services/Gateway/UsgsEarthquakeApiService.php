<?php

declare(strict_types=1);

namespace App\Services\Gateway;

use App\Services\Factory\Response\GetForPeriodresponseFactory;
use App\Services\Gateway\DTO\Request\GetForPeriodRequest;
use App\Services\Gateway\DTO\Response\GetForPeriodResponse;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class UsgsEarthquakeApiService implements EarthquakeApiServiceInterface
{
    private const BASE_URL = 'https://earthquake.usgs.gov/fdsnws/event';
    private const API_VERSION = '1';

    private const RESPONSE_FORMAT = 'geojson';
    private const DATE_FORMAT = \DateTimeInterface::ATOM;

    private PendingRequest $http;

    public function __construct(
        private readonly GetForPeriodresponseFactory $getForPeriodresponseFactory
    ) {
        $this->http = Http::baseUrl(self::BASE_URL . '/' . self::API_VERSION)->acceptJson();
    }

    public function getForPeriod(GetForPeriodRequest $request): GetForPeriodResponse
    {
        try {
            $response = $this->http->get('query', [
                'format' => self::RESPONSE_FORMAT,
                'starttime' => urlencode($request->from->format(self::DATE_FORMAT)),
                'endtime' => urlencode($request->from->format(self::DATE_FORMAT))
            ]);
        } catch (\Throwable $throwable) {
            return new GetForPeriodResponse(false, $throwable->getMessage());
        }


        if ($response->failed()) {
            return new GetForPeriodResponse(false, 'Unable to fetch earthquake data');
        }

        return $this->getForPeriodresponseFactory->fromApiResponse($response->json());
    }
}
