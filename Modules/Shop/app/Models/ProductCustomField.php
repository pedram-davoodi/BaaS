<?php

namespace Modules\Shop\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\database\factories\ProductCustomFieldFactory;

class ProductCustomField extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): ProductCustomFieldFactory
    {
        return ProductCustomFieldFactory::new();
    }
}
