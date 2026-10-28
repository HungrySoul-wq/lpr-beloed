<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
Route::get('/', fn () => redirect()->route('catalog.index'));

Route::prefix('catalog')->name('catalog.')->controller(CatalogController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/country/{country?}', 'byCountry')->name('country');
    Route::get('/code/{code}', 'byCode')
        ->where('code', '[A-Z]{2}-[0-9]{4}')->name('code');
    Route::get('/{id}', 'show')->whereNumber('id')->name('show');
});

Route::get('/feedback', [PageController::class, 'feedbackForm'])->name('feedback.form');
Route::post('/feedback', [PageController::class, 'feedbackSend'])->name('feedback.send');

Route::get('/hello/{name?}', function (string $name = 'гость') {
    return "Привет, {$name}!";
})->where('name', '\p{L}+');
Route::resource('tours', TourController::class);