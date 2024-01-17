<?php

namespace Modules\Shop\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\database\factories\OrderItemsFactory;

class OrderItems extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): OrderItemsFactory
    {
        return OrderItemsFactory::new();
    }
}
