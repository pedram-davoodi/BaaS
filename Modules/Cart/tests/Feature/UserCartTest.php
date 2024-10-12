<?php

namespace Modules\Cart\tests\Feature;

use Modules\Cart\app\Models\Cart;
use Modules\User\app\Services\UserService;

class UserCartTest extends TestCase
{
    public function setUp(): void
    {
        TestCase::setUp();
        parent::setUp();

        $this->user = $this->userRepository->faker()->create([
            'email' => 'test@test.com',
            'password' => '123456',
        ]);
        $token = (new UserService())->createAccessToken($this->user->id)->accessToken;
        $this->headers['Authorization'] = 'Bearer '.$token;
    }

    public function testNewItemCanBeAddedToCart()
    {
        $product = $this->productRepository->faker()->create();

        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 1,
            ]);

        $response->assertStatus(201)->assertSee('data')->assertJsonCount(1 , 'data.items');

    }

    public function testNoneCartableItemIsNotAccepted()
    {
        $product = $this->productRepository->faker()->create();

        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "ModelTest",
                "quantity" => 1,
            ]);

        $response->assertStatus(422)->assertSee('message');
    }

    public function testUserShouldBeLoggedInToAddNewCartItem()
    {
        $product = $this->productRepository->faker()->create();

        $response = $this->withHeaders([
            'accept' => 'Application/json'
        ])
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "ModelTest",
                "quantity" => 1,
            ]);

        $response->assertStatus(401)->assertSee('message');
    }

    public function testCartItemableHsNotEnoughQuantity()
    {
        $product = $this->productRepository->faker()->create([
            "stock" => 1,
        ]);

        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 10,
            ]);

        $response->assertStatus(422)->assertSee('message')->assertSee('limit');
    }

    public function testCartItemableIsNotExists()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => 12,
                "cartable_type" => "Product",
                "quantity" => 10,
            ]);

        $response->assertStatus(422)->assertSee('message')->assertSee('product dose not exits');
    }

    public function testTwoItemsCanBeAdded()
    {

        $product = $this->productRepository->faker()->create();

        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 1,
            ]);

        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 1,
            ]);

        $response->assertStatus(200)->assertSee('data')->assertJsonCount(2 , 'data.items');
    }

    public function testCartCanBeShown()
    {
        Cart::query()->delete();
        $product = $this->productRepository->faker()->create([
            "stock" => 1,
        ]);
        $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 1,
            ]);

        $response =$this->withHeaders($this->headers)
            ->get(route('cart.user.cart.show'))
            ->assertSee('items')
            ->assertJsonCount(1 , 'data.items')
            ->assertStatus(200);

        $this->assertEquals(1 , json_decode($response->getContent() , true)['data']['count']);
    }

    public function testUserIsNotLoggedIn()
    {
        $this->withHeaders(['accept' => 'application/json'])
            ->get(route('cart.user.cart.show'))
            ->assertSee('message')->assertStatus(401);
    }

    public function testNoItemIsInCart()
    {
        Cart::query()->delete();
        $this->withHeaders($this->headers)
            ->get(route('cart.user.cart.show'))
            ->assertSee('items')
            ->assertStatus(200)
            ->assertJsonCount(0 , 'data.items');
    }
}

