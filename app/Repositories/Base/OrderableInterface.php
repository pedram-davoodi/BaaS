<?php

namespace App\Repositories\Base;

interface OrderableInterface
{
    /**
     * get price of an orderable
     */
    public function price(int $orderable_id): int;
}
