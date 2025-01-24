<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;


Route::prefix('v1')->group(function () {
    Route::resource('pokemons', PokemonController::class);
});
