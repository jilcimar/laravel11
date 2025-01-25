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
    public function get(array $filters): array
    {
        $url = $this->apiService->getUrl();
        $result =  $this->apiService->get("$url/v2/pokemon");

        SavePokemonJob::dispatch($result['results']);

        $query = $this->applyFilters(Pokemon::query(), $filters);

        return $query->paginate(10)->toArray();
    }

    /**
     * Apply Filters
     */
    protected function applyFilters($query, array $filters)
    {
        return $query
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['type']), function ($query) use ($filters) {
                $query->where('type', $filters['type']);
            });
    }
}
