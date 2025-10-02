<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function (Request $request) {
    return response()->json(['status' => 'ok']);
})->name('health');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
