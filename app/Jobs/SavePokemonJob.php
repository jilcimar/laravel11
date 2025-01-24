<?php

namespace App\Jobs;

use App\Models\Pokemon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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

        foreach ($this->data as $pokemon) {
            try {
                Pokemon::updateOrCreate(
                    [
                        'name' => $pokemon['name']
                    ],
                    [
                        'url' => $pokemon['url'],
                    ]
                );
            } catch (Exception $e) {
                logger('error: ' . $e->getMessage());
                continue;
            }
        }
    }
}
