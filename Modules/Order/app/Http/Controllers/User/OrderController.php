<?php

namespace Modules\Order\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\OrderItemRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Order\app\Http\Requests\StoreOrderRequest;
use Modules\Order\app\Resources\OrderResource;
use Modules\Order\app\Services\OrderService;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $userId = Auth::guard('api')->id();

        $order = $orderService->createOrder(
            $userId,
            $request->get('physical_product'),
            $request->get('shipping_address'),
            $request->get('shipping_method')
        );

        $orderItems = collect($request->get('orderable_type'))
            ->map(fn($orderableType, $key) => [
                'price' => app("App\Repositories\\{$orderableType}RepositoryInterface")->price($request->get('orderable_id')[$key]),
                'orderable_id' => $request->get('orderable_id')[$key],
                'orderable_type' => $orderableType
            ]);
        $orderService->insertOrderItem($order->id, $orderItems->toArray());

        return new OrderResource($order);
    }

}
