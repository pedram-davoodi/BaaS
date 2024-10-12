<?php

namespace Modules\Cart\app\Services;

use App\Repositories\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function addNewItem(int $cartable_id, string $cartable_type, int $quantity)
    {
        //TODO: new items those added before should increase quantity not add as a new item
        $repository = app(CartRepositoryInterface::class);
        $cart = $repository->getFirstWhere(['user_id' => Auth::id()]);

        $items[] = [
            'cartable_id' => $cartable_id,
            'cartable_type' => $cartable_type,
            'quantity' => $quantity,
        ];
        if ($cart?->items){
            $items = array_merge($items, json_decode($cart->items, true));
        }

        return $repository->updateOrCreate(
            [
                'user_id' => Auth::id()
            ],
            [
                'items' => json_encode($items),
            ]
        );
    }
}
