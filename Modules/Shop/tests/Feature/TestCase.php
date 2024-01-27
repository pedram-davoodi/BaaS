<?php

namespace Modules\Shop\tests\Feature;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\ProductCategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductCategory;
use Modules\Shop\app\Repository\Eloquent\ProductCategoryRepository;
use Modules\Shop\app\Repository\Eloquent\ProductRepository;
use Modules\User\app\Models\Admin;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\Eloquent\AdminRepository;
use Tests\TestCase as BaseTestCase;
use Modules\User\app\Repository\Eloquent\UserRepository;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected array $headers = ['accept' => 'application/json'];

    protected UserRepositoryInterface  $userRepository;
    protected AdminRepositoryInterface $adminRepository;
    protected ProductRepositoryInterface $productRepository;
    protected ProductCategoryRepositoryInterface $productCategoryRepository;

    public function setUp(): void
    {
        $this->productCategoryRepository = new ProductCategoryRepository(new ProductCategory());
        $this->productRepository = new ProductRepository(new Product());
        $this->userRepository = new UserRepository(new User());
        $this->adminRepository = new AdminRepository(new Admin());

        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }
}
