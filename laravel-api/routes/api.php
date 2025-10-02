<?php

use App\Http\Controllers\Order\ExternalOrderController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function (Request $request) {
    return response()->json(['status' => 'ok']);
})->name('health');

Route::get('external', ExternalOrderController::class)->middleware('auth:sanctum')->name('external');
Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
