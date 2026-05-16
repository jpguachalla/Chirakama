<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'brand' => fake()->randomElement([
            'Toyota',
            'Honda',
            'Ford',
            'BMW',
            'Audi'
        ]),

        'model' => fake()->word(),

        'year' => fake()->numberBetween(2018, 2026),

        'price' => fake()->numberBetween(20000, 80000),

        'stock' => fake()->numberBetween(1, 20),

        'category_id' => \App\Models\Category::inRandomOrder()->first()->id
    ];
}
}
