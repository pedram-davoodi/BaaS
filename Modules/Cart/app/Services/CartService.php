<?php

namespace Modules\Cart\app\Services;

use App\Repositories\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function addNewItem(int $cartable_id, string $cartable_type, int $quantity)
    {
        // Get the CartRepository
        $repository = app(CartRepositoryInterface::class);

        // Get the cart for the current user
        $cart = $repository->getFirstWhere(['user_id' => Auth::id()]);

        // Initialize the items array from the existing cart, or start with an empty array
        $items = $cart?->items ? json_decode($cart->items, true) : [];

        // Check if the item already exists in the cart
        $itemExists = false;
        foreach ($items as &$item) {
            if ($item['cartable_id'] === $cartable_id && $item['cartable_type'] === $cartable_type) {
                // If the item exists, increase its quantity
                $item['quantity'] += $quantity;
                $itemExists = true;
                break;
            }
        }

        // If the item does not exist, add it to the items array
        if (!$itemExists) {
            $items[] = [
                'cartable_id' => $cartable_id,
                'cartable_type' => $cartable_type,
                'quantity' => $quantity,
            ];
        }

        // Update or create the cart with the new items
        return $repository->updateOrCreate(
            [
                'user_id' => Auth::id()
            ],
            [
                'items' => json_encode($items),
            ]
        );
    }

    public function removeItem(int $cartable_id, string $cartable_type, ?int $quantity = null)
    {
        // Get the CartRepository
        $repository = app(CartRepositoryInterface::class);

        // Get the cart for the current user
        $cart = $repository->getFirstWhere(['user_id' => Auth::id()]);

        // Initialize the items array from the existing cart, or start with an empty array
        $items = $cart?->items ? json_decode($cart->items, true) : [];

        // Iterate through the items to find the one to remove or reduce the quantity
        foreach ($items as $key => &$item) {
            if ($item['cartable_id'] === $cartable_id && $item['cartable_type'] === $cartable_type) {
                // If quantity is not provided, remove the entire item
                if (is_null($quantity)) {
                    unset($items[$key]);
                } else {
                    // Reduce the quantity by the given amount
                    $item['quantity'] -= $quantity;

                    // If the quantity is less than or equal to 0, remove the item from the cart
                    if ($item['quantity'] <= 0) {
                        unset($items[$key]);
                    }
                }
                break; // Exit the loop once the item is found and processed
            }
        }

        // Update the cart with the modified items (or empty cart if the item was removed)
        return $repository->updateOrCreate(
            [
                'user_id' => Auth::id()
            ],
            [
                'items' => json_encode(array_values($items)), // array_values to reindex the array
            ]
        );
    }


}
