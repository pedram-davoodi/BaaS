<?php

namespace Modules\Product\app\Models;

use App\ModelInterfaces\ProductModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\database\factories\ProductFactory;

class Product extends Model implements ProductModelInterface
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    /**
     * get price of produce
     */
    public function price(): int
    {
        return $this->price;
    }

    /**
     * Check if entered query is allowed for adding to cart
     *
     * @param int $quantity
     * @return bool
     */
    public function quantityAllowed(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function getOrderablePriceAttribute(): int
    {
        return $this->price;
    }
}
