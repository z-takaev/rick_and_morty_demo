<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::controller(PdfController::class)->group(function () {
    Route::post('/pdf/characters', 'characters')->name('pdf.characters');
});
