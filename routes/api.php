<?php

use App\Http\Controllers\ControlViajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('control', [ControlViajeController::class, 'store']);
Route::get('control/get_data_control/{id}', [ControlViajeController::class, 'get_data_control']);
