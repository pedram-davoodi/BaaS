<?php

namespace Modules\Order\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\app\Models\Order;
use Modules\Product\app\Enums\OrderStatus;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'physical_product'      => $this->faker->boolean(),
            'shipping_address'      => $this->faker->address,
            'shipping_method'       => $this->faker->word,
            'status'                => OrderStatus::cases()[array_rand(OrderStatus::cases())],
        ];
    }
}

