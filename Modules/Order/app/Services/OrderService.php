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
    /**
     * Creates a new order for a user.
     *
     * @param int $user_id The ID of the user placing the order.
     * @param string|null $shipping_address The shipping address for the order (nullable).
     * @param string|null $shipping_method The shipping method for the order (nullable).
     * @param string $status The status of the order. Defaults to 'Pending'.
     *
     * @return OrderModelInterface Returns the created order.
     */
    public function createOrder(
        int $user_id,
        ?string $shipping_address,
        ?string $shipping_method,
        string $status = 'Pending'
    ): OrderModelInterface {
        $order = app(OrderRepositoryInterface::class)->create([
            "user_id" => $user_id,
            "shipping_address" => $shipping_address,
            "shipping_method" => $shipping_method,
            'status' => $status
        ]);
        OrderCreated::dispatch($order);
        return $order;
    }

    /**
     * Creates a new order item for an order.
     *
     * @param int $order_id The ID of the order the item belongs to.
     * @param int $orderable_id The ID of the item (product or service) being ordered.
     * @param string $orderable_type The type of the item (e.g., product, service).
     * @param int $price The price of the item.
     *
     * @return OrderItemModelInterface Returns the created order item.
     */
    public function createOrderItem(
        int $order_id,
        int $orderable_id,
        string $orderable_type,
        int $price
    ): OrderItemModelInterface {
        $orderItem = app(OrderItemRepositoryInterface::class)::create([
            "order_id" => $order_id,
            "orderable_id" => $orderable_id,
            "orderable_type" => $orderable_type,
            "price" => $price,
        ]);
        OrderUpdated::dispatch(app(OrderRepositoryInterface::class)->getOneById($order_id));
        return $orderItem;
    }

    /**
     * Inserts order items into the database.
     *
     * @param int $order_id The ID of the order.
     * @param array[] $data A 2D array of order items, where each item contains the following keys:
     * - price: float The price of the item.
     * - orderable_id: int The ID of the orderable entity.
     * - orderable_type: string The type of the orderable entity.
     * @return bool Returns true if insertion is successful, false otherwise.
     */
    public function insertOrderItem(int $order_id , array$data): bool {
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
