<?php

use App\MoonShine\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('moonshine.route.prefix'))
    ->as('moonshine.')
    ->group(function() {
        Route::post('characters/name/{character}/update', [CharacterController::class, 'updateName'])
            ->name('characters.name.update');
    });
