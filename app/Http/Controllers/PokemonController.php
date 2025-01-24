<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Log\Services\PokemonService;

class PokemonController extends Controller
{
    public function __construct(protected PokemonService $pokemonService)
    {
    }

    /**
     * @throws ConnectionException
     */
    public function index(): JsonResponse
    {
        $data = $this->pokemonService->get();
        return response()->json($data);
    }

    public function show($pokemon): JsonResponse
    {
        return response()->json($pokemon);
    }
}
