<?php

namespace Modules\Shop\app\Models;

use App\ModelInterfaces\ProductModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\database\factories\ProductFactory;

class Product extends Model implements ProductModelInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
