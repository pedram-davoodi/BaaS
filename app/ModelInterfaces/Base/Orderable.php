<?php

namespace App\ModelInterfaces\Base;

Interface Orderable
{
    /**
     * get price of an orderable
     */
    public function getOrderablePriceAttribute(): int;
}
