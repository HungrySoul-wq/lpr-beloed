<?php

use App\Http\Controllers\Api\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json([
    'message' => 'pong',
    'time'    => now()->toIso8601String(),
    'student' => config('lab.slug'),
]));

// name('api.') - чтобы имена api.tours.* не совпали с веб-маршрутами tours.*
Route::name('api.')->group(function () {
    Route::apiResource('tours', TourController::class);
});
