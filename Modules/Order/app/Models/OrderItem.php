<?php

namespace Modules\Order\app\Models;

use App\ModelInterfaces\OrderItemModelInterface;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model implements OrderItemModelInterface
{
    protected $guarded = [];
}
