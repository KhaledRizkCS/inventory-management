<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        $product = Product::create(['name' => 'Burger']);

        $product->ingredients()->sync([
            1 => ['quantity' => 150],
            2 => ['quantity' => 30],
            3 => ['quantity' => 20],
        ]);
    }
}
