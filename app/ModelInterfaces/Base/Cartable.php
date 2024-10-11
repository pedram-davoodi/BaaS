<?php

namespace App\ModelInterfaces\Base;

interface Cartable
{
    /**
     * Check if entered query is allowed for adding to cart
     *
     * @param int $quantity
     * @return bool
     */
    public function quantityAllowed(int $quantity): bool;
}
