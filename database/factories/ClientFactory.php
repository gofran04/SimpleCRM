<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $num = random_int(100000000, 999999999);

        return [
            'company_name' => fake()->company(),
            'address' => fake()->address(),
            'phone' => '0'.$num,
        ];
    }
}
