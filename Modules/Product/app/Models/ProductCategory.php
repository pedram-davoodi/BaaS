<?php

namespace Modules\Product\app\Models;

use App\ModelInterfaces\ProductCategoryModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\database\factories\ProductCategoryFactory;

class ProductCategory extends Model implements ProductCategoryModelInterface
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): ProductCategoryFactory
    {
        return ProductCategoryFactory::new();
    }
}
