<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Class IngredientService.
 */
class IngredientService
{
    public function updateStockByProducts(Collection $products): void
    {
        foreach ($products as $product) {
            foreach ($product->ingredients as $ingredient) {
                print($product->quantity);
                $ingredient->current_stock -= $ingredient->pivot->quantity * $product->pivot->quantity;

                if($ingredient->current_stock < 0)
                    throw new \Exception('Ingredient out of stock');

                $ingredient->save();
            }
        }
    }
}
