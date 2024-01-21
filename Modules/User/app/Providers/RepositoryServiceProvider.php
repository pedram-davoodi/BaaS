<?php

namespace Modules\User\app\Providers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\User\app\Models\Admin;
use Modules\User\app\Models\BlockedAccount;
use Modules\User\app\Models\User;
use Modules\User\app\Models\UserProfile;
use Modules\User\app\Repository\AdminRepository;
use Modules\User\app\Repository\BlockedAccountRepository;
use Modules\User\app\Repository\UserProfileRepository;
use Modules\User\app\Repository\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, fn () => new UserRepository(new User()));
        $this->app->singleton(BlockedAccountRepository::class, fn () => new BlockedAccountRepository(new BlockedAccount()));
        $this->app->singleton(UserProfileRepository::class, fn () => new UserProfileRepository(new UserProfile()));
        $this->app->singleton(AdminRepository::class, fn () => new AdminRepository(new Admin()));

    }
}
