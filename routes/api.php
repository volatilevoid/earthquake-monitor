<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EarthquakeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/test', [UserController::class, 'test']);


Route::post('/auth/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'view'])
        ->middleware('can:view,user');
    Route::post('/create-user', [UserController::class, 'create'])
        ->middleware('can:create,user');
    Route::get('/earthquakes', [EarthquakeController::class, 'getEarthquakes']);
    Route::post('/set-magnitude-threshold', [EarthquakeController::class, 'setMagnitudeThreshold']);
    Route::get('/auth/me', [UserController::class, 'userDetails']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
