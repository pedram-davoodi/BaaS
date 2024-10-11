<?php

use Modules\Product\tests\Feature\TestCase;
use Modules\User\app\Services\UserService;

class UserProductTest extends TestCase
{

    private string $userToken;

    public function setUp(): void
    {
        TestCase::setUp();
    }

    public function testProductsListCanBeShown()
    {
        $this->productRepository->faker()->count(10)->create();

        $response = $this
            ->withHeaders($this->headers)
            ->get(route('product.user.products.index'));

        $response->assertStatus(200);
        $response->assertSee('data');
        $response->assertJsonCount(10 , 'data');
    }

    public function testProductDetailCanBeShow()
    {
        $this->productRepository->faker()->create([
            'name' => 'Test Product',
        ]);

        $response = $this
            ->withHeaders($this->headers)
            ->get(route('product.user.products.show',1));

        $response->assertStatus(200);
        $response->assertSee('Test Product');
    }

    public function testNoProductFound()
    {
        $response = $this
            ->withHeaders($this->headers)
            ->get(route('product.user.products.show', 12));

        $response->assertStatus(404);
        $response->assertSee('Record not found.');
    }
}

