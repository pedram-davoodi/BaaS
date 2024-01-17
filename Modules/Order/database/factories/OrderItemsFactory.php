<?php

namespace Modules\Order\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Shop\app\Models\OrderItems::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'price' => rand(10 , 10000)
        ];
    }
}

