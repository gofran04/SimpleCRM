<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'description' => fake()->paragraph(),
            'project_owner' => function(){
                return Client::factory()->create()->id;
            },
            'started_at' => now(),
            'dead_line' => now()->addDays(90)
        ];
    }
}
