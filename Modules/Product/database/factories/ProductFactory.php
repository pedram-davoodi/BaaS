<?php

namespace Modules\Product\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\app\Models\Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "price" => rand(100,1000000),
            "image_path" => $this->faker->imageUrl,
            "stock" => rand(1,100),
            "description" => $this->faker->text(100),
        ];
    }
}

