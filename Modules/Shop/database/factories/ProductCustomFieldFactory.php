<?php

namespace Modules\Shop\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCustomFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Shop\app\Models\ProductCustomField::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->word ,
            "value" => $this->faker->word ,
        ];
    }
}

