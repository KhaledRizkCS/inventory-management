<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class IngredientService.
 */
class IngredientService
{
    public function updateStockByProducts(Collection $products): void
    {
        foreach ($products as $product) {
            foreach ($product->ingredients as $ingredient) {
                $ingredient->current_stock -= $ingredient->pivot->quantity * $product->pivot->quantity;

                if($ingredient->current_stock < 0){
                    throw new HttpException(400, "Ingredient {$ingredient->name} is out of stock");
                }

                $ingredient->save();
            }
        }
    }
}
