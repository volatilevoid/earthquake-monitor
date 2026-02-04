<?php

namespace App\Http\Controllers;

use App\Helper\CacheKeyHelper;
use App\Models\Config;
use App\Models\Earthquake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EarthquakeController extends Controller
{
    public function getEarthquakes(Request $request)
    {
        if ($request->user()->isSuperAdmin()) {

            if (Cache::tags(CacheKeyHelper::EARTHQUAKES_TAG)->has(CacheKeyHelper::getEarthquakesCacheKey())) {
                return Cache::tage(CacheKeyHelper::EARTHQUAKES_TAG)->get(CacheKeyHelper::getEarthquakesCacheKey());
            }

            $earthquakes = Earthquake::all();

            Cache::tags(CacheKeyHelper::EARTHQUAKES_TAG)->put(CacheKeyHelper::getEarthquakesCacheKey(), $earthquakes);

            return [
                'success' => true,
                'message' => '',
                'data' => $earthquakes,
            ];
        }

        $a = Cache::tags('earthquakes')->has('test');

        $config = $request->user()->config;

        if (is_null($config)) {
            return [
                'success' => false,
                'message' => 'User did not set magnitude threshold',
            ];
        }


        if (Cache::tags(CacheKeyHelper::EARTHQUAKES_TAG)->has(CacheKeyHelper::getEarthquakesForUser($request->user()))) {
            return Cache::tags(CacheKeyHelper::EARTHQUAKES_TAG)->get(CacheKeyHelper::getEarthquakesForUser($request->user()));
        }

        $earthquakes = Earthquake::where('magnitude', '>', $config->magnitude_threshold)->get();


        Cache::tags(CacheKeyHelper::EARTHQUAKES_TAG)->put(CacheKeyHelper::getEarthquakesForUser($request->user()), $earthquakes);

        return [
            'success' => true,
            'message' => '',
            'data' => $earthquakes,
        ];
    }

    public function setMagnitudeThreshold(Request $request)
    {
        $request->validate([
            'threshold' => ['required', 'numeric'],
        ]);

        if ($request->user()->isSuperAdmin()) {
            $config = Config::whereNull('user_id')->first();

            if (is_null($config)) {
                Config::factory()->create([
                    'user_id' => null,
                    'magnitude_threshold' => $request->threshold,
                ]);

                return ['success' => true];
            }

            $config->user_id = null;
            $config->magnitude_threshold = $request->threshold;

            $config->save();

            return ['success' => true];
        }

        $request->user()->config()->updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'magnitude_threshold' => $request->threshold
            ]
        );

        return ['success' => true];
    }
}
