<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
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
        $data = $this->pokemonService->get(Request::query());
        return response()->json($data);
    }

    public function show(Pokemon $pokemon): JsonResponse
    {
        return response()->json($pokemon);
    }
}
