<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;


Route::prefix('api/v1')->group(function () {
    Route::get('/', function (){
        return response()->json(['API v1']);
    });

    Route::resource('pokemons', PokemonController::class);
});
