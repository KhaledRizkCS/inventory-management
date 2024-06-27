<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Order;

class ProductTest extends TestCase
{
    public function test_create_product(): void
    {
        $product = Product::factory()->create();
        $this->assertNotNull($product);
    }

    public function test_product_has_ingredients(): void
    {
        $product = Product::factory()->create();
        $ingredients = Ingredient::factory()->count(3)->create();
        foreach ($ingredients as $ingredient) {
            $product->ingredients()->attach($ingredient, ['quantity' => random_int(50, 300)]);
        }
        $this->assertCount(3, $product->ingredients);
    }

    public function test_product_has_orders(): void
    {
        $product = Product::factory()->create();
        $orders = Order::factory()->count(3)->create();
        foreach ($orders as $order) {
            $product->orders()->attach($order, ['quantity' => random_int(1, 20)]);
        }
        $this->assertCount(3, $product->orders);
    }
}
