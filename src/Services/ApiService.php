<?php

namespace Log\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $url;

    public function __construct()
    {
        $this->url = env('API_URL', 'https://pokeapi.co/api/');
    }

    /**
     * @throws ConnectionException
     */
    public function get(string $endpoint, array $params = []): array
    {
        $response = Http::withHeader('Accept', 'application/json')
            ->get($endpoint, $params);

        if ($response->failed()) {
            throw new ConnectionException();
        }

        return $response->json();
    }

    public function getUrl()
    {
        return $this->url;
    }
}
