<?php

use App\Http\Controllers\Api\MqSensorController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// //CRUD
// Route::get('/users', [UserController::class, 'index']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::get('/users', [UserController::class, 'store']);
// Route::get('/users/{id}', [UserController::class, 'update']);
// Route::get('/users/{id}', [UserController::class, 'destroy']);

//route group api
Route::group(['as' => 'api.'], function (){
    //resource
    Route::resource('users', UserController::class)
    ->except(['create', 'edit']);

    Route::resource('sensors/mq', MqSensorController::class)
        ->names('sensors.mq');
});

