<?php

namespace Modules\Order\app\Models;

use App\ModelInterfaces\OrderModelInterface;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements OrderModelInterface
{
    protected $guarded = [];
}
