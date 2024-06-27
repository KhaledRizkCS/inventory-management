<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total_stock = fake()->numberBetween(1000, 100000);
        $current_stock = fake()->numberBetween(1000, $total_stock);
        return [
            'name' => fake()->name(),
            'total_stock' => $total_stock,
            'current_stock' => $current_stock,
        ];
    }
}
