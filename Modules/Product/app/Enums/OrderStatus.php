<?php

namespace Modules\Product\app\Enums;

enum OrderStatus
{
    case Pending;
    case Processing;
    case Shipping;
    case Done;
    case Refunded;
    case Cancelled;
}
