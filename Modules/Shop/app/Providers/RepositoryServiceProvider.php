<?php

namespace Modules\Shop\app\Providers;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\BlockedAccountRepositoryInterface;
use App\Repositories\PasswordResetTokenRepositoryInterface;
use App\Repositories\ProductCategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductCategory;
use Modules\Shop\app\Repository\Eloquent\ProductCategoryRepository;
use Modules\Shop\app\Repository\Eloquent\ProductRepository;
use Modules\User\app\Models\Admin;
use Modules\User\app\Models\BlockedAccount;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
use Modules\User\app\Models\UserProfile;
use Modules\User\app\Repository\Eloquent\AdminRepository;
use Modules\User\app\Repository\Eloquent\BlockedAccountRepository;
use Modules\User\app\Repository\Eloquent\PasswordResetTokenRepository;
use Modules\User\app\Repository\Eloquent\UserRepository;
use Modules\User\app\Repository\Eloquent\UserProfileRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(ProductCategoryRepositoryInterface::class, fn () => new ProductCategoryRepository(new ProductCategory()));
        $this->app->singleton(ProductRepositoryInterface::class, fn () => new ProductRepository(new Product()));
    }
}
