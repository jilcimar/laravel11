<?php

namespace App\Jobs;

use App\Models\Pokemon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Log\Services\ApiService;

class SavePokemonJob implements ShouldQueue
{
    use Queueable;

    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger('saving data - async');

        $apiService = new ApiService();

        foreach ($this->data as $pokemon) {
            try {
                $url = $pokemon['url'];
                $name = $pokemon['name'];

                if (Pokemon::where('name', $name)->exists()) {
                    continue;
                }

                $details = $apiService->get($url);

                $type = $details['types'][0]['type']['name'] ?? 'unknown';

                $weight = $details['weight'] ? convertGramsToKilograms($details['weight']) : 0;

                $height = $details['height'] ? convertCmToMeters($details['height']) : 0;

                Pokemon::create(
                    [
                        'name' => $name,
                        'type' => $type,
                        'weight' => $weight,
                        'height' => $height,
                        'url' => $pokemon['url']
                    ]
                );
            } catch (Exception $e) {
                logger('error: ' . $e->getMessage());
                continue;
            }
        }
    }
}
