<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Earthquake;
use Illuminate\Http\Request;

class EarthquakeController extends Controller
{
    public function getEarthquakes(Request $request)
    {

        if ($request->user()->isSuperAdmin()) {
            $earthquakes = Earthquake::all();

            return [
                'success' => true,
                'message' => '',
                'data' => $earthquakes,
            ];
        }

        $config = $request->user()->config;

        if (is_null($config)) {
            return [
                'success' => false,
                'message' => 'User did not set magnitude threshold',
            ];
        }

        $earthquakes = Earthquake::where('magnitude', '>', $config->magnitude_threshold)->get();

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
