<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;

class OrderTest extends TestCase
{

    public function test_create_order(): void
    {
        $order = Order::factory()->create();
        $this->assertNotNull($order);
    }

    public function test_order_has_products(): void
    {
        $order = Order::factory()->create();
        $products = Product::factory()->count(3)->create();
        foreach ($products as $product) {
            $order->products()->attach($product, ['quantity' => random_int(1, 20)]);
        }
        $this->assertCount(3, $order->products);
    }
}
