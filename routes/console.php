<?php

use App\Models\LastProcessEarthquakesRunLog;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:process-earthquakes', [(new \DateTimeImmutable())->getTimestamp()])
    ->hourly()
    ->onSuccess(function () {
        $lastRun = LastProcessEarthquakesRunLog::first();

        if (is_null($lastRun)) {
            $lastRun = new LastProcessEarthquakesRunLog();
        }

        $lastRun->finished_at = new \DateTimeImmutable('now');
        $lastRun->save();
    });
