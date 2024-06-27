<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ingredient;

class OrderTest extends TestCase
{

    use RefreshDatabase;

    private  $storeOrderUrl = '/api/order';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_store_order(): void
    {
        $payload = [
            'products' => [
                [
                    'product_id' => Product::first()->id,
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(201);

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertEquals($payload['products'][0]['product_id'], $order->products[0]->id);
    }

    public function test_store_order_with_invalid_product_id(): void
    {
        $payload = [
            'products' => [
                [
                    'product_id' => 999,
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(422);
    }

    public function test_store_order_with_missing_quantity(): void
    {
        $payload = [
            'products' => [
                [
                    'product_id' => Product::first()->id
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(422);
    }

    public function test_store_order_with_invalid_quantity(): void
    {
        $payload = [
            'products' => [
                [
                    'product_id' => Product::first()->id,
                    'quantity' => -1
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(422);
    }

    public function test_store_order_with_missing_product_id(): void
    {
        $payload = [
            'products' => [
                [
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(422);
    }

    public function test_store_order_with_missing_products(): void
    {
        $payload = [];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(422);
    }

    public function test_store_order_with_out_of_stock_ingredient(): void
    {
        $product = Product::first();
        $ingredient = $product->ingredients->first();
        $ingredient->current_stock = 0;
        $ingredient->save();

        $payload = [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(400);
    }

    public function test_store_order_with_ingredient_below_50_percent(): void
    {
        $product = Product::first();
        $ingredient = $product->ingredients->first();
        $ingredient->current_stock = $ingredient->total_stock * 0.5;
        $ingredient->save();

        $payload = [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(201);
        $ingredient = Ingredient::find($ingredient->id);
        $this->assertEquals(true, $ingredient->email_sent);
    }

    public function test_store_order_with_ingredient_over_50_percent(): void
    {
        $product = Product::first();

        $payload = [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->postJson($this->storeOrderUrl, $payload);
        $response->assertStatus(201);
        $ingredient = $product->ingredients->first();
        $this->assertEquals(false, $ingredient->email_sent);
    }
}
