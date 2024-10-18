<?php

namespace Modules\Order\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Modules\Order\app\Http\Requests\StoreCartOrderRequest;
use Modules\Order\app\Resources\OrderResource;
use Modules\Order\app\Services\OrderService;

class CartOrderController extends Controller
{

    public function store(StoreCartOrderRequest $request, OrderService $orderService , CartRepositoryInterface $cartRepository)
    {
        $cart = $cartRepository->getFirstWhere(['user_id' => Auth::id()]);
        if (empty($cart?->items)){
            return jsonResponse(message: __('user.cart.empty'), code: 422);
        }

        $cartItems = json_decode($cart->items , true);

        $order = $orderService->createOrder(
            Auth::guard('api')->id(),
            $request->get('shipping_address'),
            $request->get('shipping_method')
        );
        $orderItems = [];
        collect($cartItems)
            ->each(function ($cartItem) use (&$orderItems) {
                for ($count = 0; $count < $cartItem['quantity'] ; $count++) {
                    $orderItems[] = [
                        'price' => app("App\Repositories\\{$cartItem['cartable_type']}RepositoryInterface")
                            ->getOneByIdOrFail($cartItem['cartable_id'])
                            ->orderable_price,
                        'orderable_id' => $cartItem['cartable_id'],
                        'orderable_type' => $cartItem['cartable_type']
                    ];
                }
            });

        $orderService->insertOrderItem($order->id, $orderItems);
        $cartRepository->delete(['user_id' => Auth::id()]);

        return new OrderResource($order);
    }
}
