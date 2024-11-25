<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\MoonShine\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::controller(PdfController::class)->group(function () {
    Route::post('/pdf/characters', 'characters')->name('pdf.characters');
});

Route::post('/moonshine/characters/{character}/status/update', CharacterController::class)
    ->name('moonshine.characters.status.update')
    ->middleware('moonshine');
