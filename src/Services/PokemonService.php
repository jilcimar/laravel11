<?php

namespace Log\Services;

use App\Jobs\SavePokemonJob;
use App\Models\Pokemon;
use Illuminate\Http\Client\ConnectionException;

class PokemonService
{
    protected ApiService $apiService;
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @throws ConnectionException
     */
    public function get(): array
    {
        $result =  $this->apiService->get('v2/pokemon');

        SavePokemonJob::dispatch($result['results']);

        return  $result;
    }
}
