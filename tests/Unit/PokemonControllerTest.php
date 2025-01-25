<?php

namespace Tests\Unit;

use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Log\Services\PokemonService;
use Mockery;
use Tests\TestCase;

class PokemonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_pokemon_data(): void
    {
        $mockedService = Mockery::mock(PokemonService::class);
        $mockedService->shouldReceive('get')
            ->with(['name' => 'pikachu', 'type' => 'electric'])
            ->andReturn([
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Pikachu',
                        'type' => 'electric',
                        'height' => 0,
                        'weight' => 0,
                        'url' => 'localhost.com',
                        'created_at' => '2025-01-25 00:00:00',
                        'updated_at' => '2025-01-25 00:00:00',
                    ],
                ],
                'total' => 1,
                'current_page' => 1,
                'next_page_url' => null,
                'per_page' => 10,
                'prev_page_url' => null,
                'path' => 'localhost.com',
            ]);

        $this->app->instance(PokemonService::class, $mockedService);

        $response = $this->getJson('api/v1/pokemons?name=pikachu&type=electric');

        $response->assertStatus(200)
            ->assertJsonFragment(
                [
                    'id' => 1,
                    'name' => 'Pikachu',
                    'type' => 'electric',
                    'height' => 0,
                    'weight' => 0,
                    'url' => 'localhost.com',
                    'created_at' => '2025-01-25 00:00:00',
                    'updated_at' => '2025-01-25 00:00:00',
                ]
            );
    }

    public function test_show_returns_specific_pokemon(): void
    {
        $pokemon = Pokemon::factory()->create([
            'name' => 'Bulbasaur',
            'type' => 'grass',
            'height' => 1,
            'weight' => 1,
            'url' => 'localhost.com',
        ]);

        $response = $this->getJson("api/v1/pokemons/{$pokemon->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Bulbasaur',
                'type' => 'grass',
            ]);
    }
}
