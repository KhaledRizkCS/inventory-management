<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Ingredient;

class IngredientTest extends TestCase
{
    public function test_create_ingredient(): void
    {
        $ingredient = Ingredient::factory()->create();
        $this->assertNotNull($ingredient);
        $this->assertEquals(false, $ingredient->email_sent);
    }

    public function test_ingredient_has_products(): void
    {
        $ingredient = Ingredient::factory()->create();
        $products = Product::factory()->count(3)->create();
        foreach ($products as $product) {
            $ingredient->products()->attach($product, ['quantity' => random_int(50, 300)]);
        }
        $this->assertCount(3, $ingredient->products);
    }
}
