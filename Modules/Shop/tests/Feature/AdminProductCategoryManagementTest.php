<?php

namespace Modules\Shop\tests\Feature;

use App\Events\ProductCategoryDeleted;
use App\Events\ProductCategoryUpdated;
use App\Events\ProductUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Modules\Shop\tests\Feature\TestCase;

class AdminProductCategoryManagementTest extends TestCase
{

    private string $adminToken;

    public function setUp(): void
    {
        TestCase::setUp();
        $this->adminToken = $this->adminRepository->createAccessToken($this->adminRepository->faker()->create()->id)->accessToken;
    }

    public function testProductCategoryCanBeCreatedByAdmin(): void
    {
        $response = $this
            ->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->post(route('shop.admin.product-categories.store' , [
                "name" => fake()->name,
            ]));


        $response->assertStatus(201)->assertSee('data');
        $this->assertCount(1 , $this->productCategoryRepository->getAll());
    }

    public function testProductCategoryCantBeCreatedByGuest(): void
    {
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('shop.admin.product-categories.store' , [
                "name" => fake()->name,
            ]));

        $response->assertStatus(401)->assertSee('message');
    }

    public function testProductCategoryCantBeCreatedByValidationNameError(): void
    {
        $response = $this
            ->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->post(route('shop.admin.product-categories.store'));

        $response->assertJsonValidationErrors('name');
    }


    public function testProductCategoryIndexCanBeShown()
    {
        $this->productCategoryRepository->faker()->count(10)->create();

        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->get(route('shop.admin.product-categories.index'));

        $response->assertStatus(200);
        $response->assertSee('data');
        $this->assertCount(10 , $response->json()['data']);
    }

    public function testProductCategoryIndexShouldBePaginated()
    {
        $this->productCategoryRepository->faker()->count(45)->create();

        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->get(route('shop.admin.product-categories.index'));

        $response->assertStatus(200);
        $response->assertSee('data');
        $response->assertSee('per_page');
        $response->assertSee('total');
        $this->assertCount(10 , $response->json()['data']);
        $this->assertEquals(45 , $response->json()['meta']['total']);
        $this->assertEquals(10 , $response->json()['meta']['per_page']);
    }

    public function testProductCategoryIndexCanBeShownToAdminOnly()
    {
        $this->productRepository->faker()->count(10)->create();

        $response = $this->withHeaders($this->headers)
            ->get(route('shop.admin.product-categories.index'));

        $response->assertStatus(401);
        $response->assertSee('message');
    }

    public function testProductCategoryCanBeDeleted()
    {
        Event::fake();
        $this->productRepository->faker()->create([
            'product_category_id' => $this->productCategoryRepository->faker()->create()->id
        ]);
        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->delete(route('shop.admin.product-categories.destroy' , 1));

        $product = $this->productCategoryRepository->getOneByIdOrFailWithTrashed(1);
        $response->assertStatus(200);
        $response->assertSee('message');
        $this->assertNotNull($product->deleted_at);
        Event::assertDispatched(ProductCategoryDeleted::class);
    }

    public function testProductCategoryCantBeDeletedByGuess()
    {
        Event::fake();
        $this->productRepository->faker()->create();
        $response = $this->withHeaders($this->headers)
            ->delete(route('shop.admin.product-categories.destroy' , 1));
        $response->assertStatus(401);
        $response->assertSee('message');
        Event::assertNotDispatched(ProductCategoryDeleted::class);
    }

    public function testProductCategoryCanBeUpdatedByAdmin(): void
    {
        Event::fake();
        $category = $this->productCategoryRepository->faker()->create();
        $response = $this
            ->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->put(route('shop.admin.product-categories.update' , 1 ) ,  [
                "name" => $name = fake()->name,
            ]);

        $response->assertStatus(200)->assertSee('data');
        $this->assertEquals($name , $response->json()['data']['name']);
        Event::assertDispatched(ProductCategoryUpdated::class);
    }

    public function testProductCategoryCantBeUpdatedByGuest(): void
    {
        Event::fake();
        $category = $this->productCategoryRepository->faker()->create();

        $response = $this
            ->withHeaders($this->headers)
            ->put(route('shop.admin.product-categories.update' , 1 ) ,  [
                "name" => $name = fake()->name,
            ]);
        $response->assertStatus(401)->assertSee('message');
        Event::assertNotDispatched(ProductUpdated::class);
    }

}

