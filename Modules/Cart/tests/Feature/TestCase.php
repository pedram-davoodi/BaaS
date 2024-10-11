<?php

namespace Modules\Cart\tests\Feature;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\ProductCategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Cart\app\Models\Cart;
use Modules\Cart\app\Repository\Eloquent\CartRepository;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductCategory;
use Modules\Product\app\Repository\Eloquent\ProductCategoryRepository;
use Modules\Product\app\Repository\Eloquent\ProductRepository;
use Modules\User\app\Models\Admin;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\Eloquent\AdminRepository;
use Tests\TestCase as BaseTestCase;
use Modules\User\app\Repository\Eloquent\UserRepository;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected array $headers = ['accept' => 'application/json'];

    protected UserRepositoryInterface $userRepository;
    protected ProductRepositoryInterface $productRepository;
    protected CartRepositoryInterface $cartRepository;

    public function setUp(): void
    {
        $this->cartRepository = new CartRepository(new Cart());
        $this->userRepository = new UserRepository(new User());
        $this->productRepository = new ProductRepository(new Product());

        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }
}
