<?php

use App\Http\Controllers\Api\RainSensorController;
use App\Http\Controllers\Api\Dht11SensorController;
use App\Http\Controllers\Api\MqSensorController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//route group api
Route::group(['as' => 'api.'], function (){
    //resource
    Route::resource('users', UserController::class)
    ->except(['create', 'edit']);

    Route::resource('sensors/mq', MqSensorController::class)
        ->names('sensors.mq');

    Route::resource('sensors/dht11', Dht11SensorController::class)->names('sensors.dht11');

    //Route::resource('sensors/rain', RainSensorController::class)->names('sensors.rain');
    Route::apiResource('rain-sensors', RainSensorController::class);
});

