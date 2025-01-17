<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Mail\IngredientRunningLow;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'total_stock', 'current_stock'];

    public static function boot(){
        parent::boot();
        static::updating(function($ingredient){
            if (
                $ingredient->isDirty('current_stock')
                && $ingredient->current_stock <= $ingredient->total_stock / 2
                && !$ingredient->email_sent
            ) {

                Mail::to(env("VENDOR_EMAIL"))->queue(new IngredientRunningLow($ingredient));
                $ingredient->email_sent = true;
                $ingredient->save();
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredient')->withPivot('quantity');
    }
}
