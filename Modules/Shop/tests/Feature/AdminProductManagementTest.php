<?php

namespace Modules\Shop\tests\Feature;

use Illuminate\Support\Str;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductCategory;
use Modules\User\app\Models\Admin;
use Modules\User\app\Services\AdminService;

class AdminProductManagementTest extends TestCase
{

    private string $adminToken;

    public function setUp(): void
    {
        parent::setUp();
        $this->adminToken = (new AdminService())->createAccessToken(Admin::factory()->create())->accessToken;
    }

    public function testProductCanBeCreatedByAdmin(): void
    {
        $category = ProductCategory::factory()->create();
        $response = $this
            ->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->post(route('shop.admin.product.store' , [
                "name" => fake()->name,
                'product_product_category_id' => $category->id,
                "price" => rand(1000, 100000),
                "image" => base64_encode(Str::random(50)),
                "description" => fake()->text(),
            ]));

        $response->assertStatus(201)->assertSee('data');
        $this->assertCount(1 , Product::all());
        $this->assertSame($category->id , Product::firts()->product_category_id);
    }

    public function testProductCantBeCreatedByGuest(): void
    {
        $category = ProductCategory::factory()->create();
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('shop.admin.product.store' , [
                "name" => fake()->name,
                'product_category_id' => $category->id,
                "price" => rand(1000, 100000),
                "image" => base64_encode(Str::random(50)),
                "description" => fake()->text(),
            ]));

        $response->assertStatus(403)->assertSee('message');
    }

    public function testProductCantBeCreatedByValidationNameError(): void
    {
        $category = ProductCategory::factory()->create();
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('shop.admin.product.store' , [
                'product_category_id' => $category->id,
                "price" => rand(1000, 100000),
                "image" => base64_encode(Str::random(50)),
                "description" => fake()->text(),
            ]));

        $response->assertJsonValidationErrors('name');
    }

    public function testProductCantBeCreatedByValidationCategoryIdError(): void
    {
        $category = ProductCategory::factory()->create();
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('shop.admin.product.store' , [
                "name" => fake()->name,
                "price" => rand(1000, 100000),
                "image" => base64_encode(Str::random(50)),
                "description" => fake()->text(),
            ]));

        $response->assertJsonValidationErrors('product_category_id');
    }

    public function testProductCantBeCreatedByValidationPriceError(): void
    {
        $category = ProductCategory::factory()->create();
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('shop.admin.product.store' , [
                "name" => fake()->name,
                'product_category_id' => $category->id,
                "price" => "sadasd",
                "image" => base64_encode(Str::random(50)),
                "description" => fake()->text(),
            ]));

        $response->assertJsonValidationErrors('price');
    }

    public function testProductCantBeCreatedByValidationImageError(): void
    {
        $category = ProductCategory::factory()->create();
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('shop.admin.product.store' , [
                "name" => fake()->name,
                'product_category_id' => $category->id,
                "price" => rand(1000, 100000),
                "description" => fake()->text(),
            ]));

        $response->assertJsonValidationErrors('image');
    }
}

