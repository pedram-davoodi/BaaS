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
        $product2 = $this->productRepository->faker()->create();

        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product2->id,
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

    public function testTwoSimilarItemsCanBeAdded()
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

        $response->assertStatus(200)->assertSee('data')->assertJsonCount(1 , 'data.items');
        $this->assertEquals(2 , json_decode($response->getContent() , true)['data']['items'][0]['quantity']);
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

    /**
     * Test removing an item from the cart by quantity.
     */
    public function testItemCanBeRemovedByQuantity()
    {
        $product = $this->productRepository->faker()->create();

        // Add item to the cart first
        $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 5,
            ]);

        // Now remove 2 units from the product in the cart
        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.delete'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 2,
            ]);

        $response->assertStatus(200)->assertSee('data')->assertJsonPath('data.items.0.quantity', 3); // Remaining quantity
    }

    /**
     * Test removing an entire item if no quantity is provided.
     */
    public function testItemCanBeRemovedCompletelyWithoutQuantity()
    {
        $product = $this->productRepository->faker()->create();

        // Add item to the cart first
        $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 1,
            ]);

        // Now remove the item without specifying quantity
        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.delete'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
            ]);

        $response->assertStatus(200)->assertSee('data')->assertJsonCount(0, 'data.items'); // Item is completely removed
    }

    /**
     * Test trying to remove an item that doesn't exist in the cart.
     */
    public function testNonExistentItemCannotBeRemoved()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.delete'), [
                "cartable_id" => 999, // Non-existent cartable_id
                "cartable_type" => "Product",
            ]);

        $response->assertStatus(422)->assertSee('message')->assertSee('product dose not exits');
    }

    /**
     * Test trying to remove an item with an invalid quantity.
     */
    public function testInvalidQuantityCannotBeRemoved()
    {
        $product = $this->productRepository->faker()->create();

        // Add item to the cart first
        $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.store'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => 5,
            ]);

        // Now try to remove with invalid quantity
        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.delete'), [
                "cartable_id" => $product->id,
                "cartable_type" => "Product",
                "quantity" => -1,
            ]);

        $response->assertStatus(422)->assertSee('message')->assertSee('quantity');
    }

    /**
     * Test user must be authenticated to remove cart items.
     */
    public function testUserMustBeAuthenticatedToRemoveCartItem()
    {
        $product = $this->productRepository->faker()->create();

        // Try to remove without being authenticated
        $response = $this->withHeaders(['accept' => 'application/json'])->post(route('cart.user.cart.delete'), [
            "cartable_id" => $product->id,
            "cartable_type" => "Product",
        ]);

        $response->assertStatus(401)->assertSee('message');
    }

    /**
     * Test removing from an empty cart.
     */
    public function testRemovingItemFromEmptyCart()
    {
        Cart::query()->delete(); // Ensure the cart is empty

        // Try to remove an item from an empty cart
        $response = $this->withHeaders($this->headers)
            ->post(route('cart.user.cart.delete'), [
                "cartable_id" => 1,
                "cartable_type" => "Product",
            ]);

        $response->assertStatus(422)->assertSee('product dose not exits');
    }
}

