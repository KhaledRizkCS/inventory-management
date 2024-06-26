<?php

namespace App\Services;

use App\Models\Order;
use App\Services\IngredientsService;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderService.
 */
class OrderService
{
    public function __construct(
        private Order $orderRepository,
        private IngredientService $ingredientService
    ) {}

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = $this->orderRepository->create([]);
            $order->products()->sync($this->createProductsSyncData($data['products']));
            $order->load(['products' => function ($query) {
                $query->with(['ingredients' => function ($query) {
                    $query->lockForUpdate();
                }]);
            }]);
            $this->ingredientService->updateStockByProducts($order->products);
            return $order;
        });
    }

    private function createProductsSyncData(array $products): array
    {
        $productsData = [];
        foreach ($products as $product) {
            $productsData[$product['product_id']] = ['quantity' => $product['quantity']];
        }
        return $productsData;
    }


}
