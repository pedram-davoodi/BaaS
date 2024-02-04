<?php

namespace Modules\Order\app\Services;

use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\ModelInterfaces\OrderItemModelInterface;
use App\ModelInterfaces\OrderModelInterface;
use App\Repositories\OrderItemRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;

class OrderService
{
    public function createOrder(
        int $user_id,
        string $physical_product,
        ?string $shipping_address,
        ?string $shipping_method,
        string $status = 'Pending',
    ): OrderModelInterface{
        $order = app(OrderRepositoryInterface::class)->create([
            "user_id" => $user_id,
            "physical_product" => $physical_product,
            "shipping_address" => $shipping_address,
            "shipping_method" => $shipping_method,
            'status' => $status
        ]);
        OrderCreated::dispatch($order);
        return $order;
    }

    public function createOrderItem(
        int $order_id,
        int $orderable_id,
        string $orderable_type,
        int $price
    ): OrderItemModelInterface {
        $orderItem =  app(OrderItemRepositoryInterface::class)::create([
            "order_id" => $order_id,
            "orderable_id" => $orderable_id,
            "orderable_type" => $orderable_type,
            "price" => $price,
        ]);
        OrderUpdated::dispatch(app(OrderRepositoryInterface::class)->getOneById($order_id));
        return $orderItem;
    }

    public function insertOrderItem(int $order_id , $data): bool {
        foreach ($data as &$value){
            $value['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $value['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $value['order_id'] = $order_id;
        }

        $result = app(OrderItemRepositoryInterface::class)->insert($data);
        if ($result) {
            OrderUpdated::dispatch(app(OrderRepositoryInterface::class)->getOneById($order_id));
        }
        return $result;
    }
}
