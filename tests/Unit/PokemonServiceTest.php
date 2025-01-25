<?php

namespace Tests\Unit;

use App\Jobs\SavePokemonJob;
use App\Models\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Queue;
use Log\Services\ApiService;
use Log\Services\PokemonService;
use Mockery;
use Tests\TestCase;

class PokemonServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws ConnectionException
     */
    public function test_get_fetches_and_applies_filters(): void
    {
        Queue::fake();

        $mockedApiService = Mockery::mock(ApiService::class);

        $mockedApiService->shouldReceive('getUrl')
            ->andReturn('https://pokeapi.co/api');

        $mockedApiService->shouldReceive('get')
            ->with('https://pokeapi.co/api/v2/pokemon')
            ->andReturn([
                'results' => [
                    ['name' => 'Bulbasaur'],
                    ['name' => 'Charmander'],
                ]
            ]);

        $this->app->instance(ApiService::class, $mockedApiService);

        Queue::assertNothingPushed();

        Pokemon::factory()->create(['name' => 'Bulbasaur', 'type' => 'grass']);
        Pokemon::factory()->create(['name' => 'Charmander', 'type' => 'fire']);
        Pokemon::factory()->create(['name' => 'Pikachu', 'type' => 'electric']);

        $service = new PokemonService($mockedApiService);
        $filters = ['name' => 'Bulbasaur', 'type' => 'grass'];

        $result = $service->get($filters);

        $this->assertCount(1, $result['data']);
        $this->assertEquals('Bulbasaur', $result['data'][0]['name']);
        $this->assertEquals('grass', $result['data'][0]['type']);

        Queue::assertPushed(SavePokemonJob::class);
    }
}
