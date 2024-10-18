<?php

namespace Modules\Order\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\app\Http\Requests\StoreOrderRequest;
use Modules\Order\app\Resources\OrderResource;
use Modules\Order\app\Services\OrderService;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->createOrder(
            Auth::guard('api')->id(),
            $request->get('shipping_address'),
            $request->get('shipping_method')
        );

        $orderItems = collect($request->get('orderable_type'))
            ->map(fn($orderableType, $key) => [
                'price' => app("App\Repositories\\{$orderableType}RepositoryInterface")
                    ->getOneByIdOrFail($request->get('orderable_id')[$key])
                    ->orderable_price,
                'orderable_id' => $request->get('orderable_id')[$key],
                'orderable_type' => $orderableType
            ]);
        $orderService->insertOrderItem($order->id, $orderItems->toArray());

        return new OrderResource($order);
    }

}
