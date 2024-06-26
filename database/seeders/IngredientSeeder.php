<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ingredient::truncate();

        $ingredients = [
            ['name' => 'Beef', 'total_stock' => 200, 'current_stock' => 200],
            ['name' => 'Cheese', 'total_stock' => 50, 'current_stock' => 50],
            ['name' => 'Onion', 'total_stock' => 10, 'current_stock' => 10],
        ];

        Ingredient::insert($ingredients);
    }
}
