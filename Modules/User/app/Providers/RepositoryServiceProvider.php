<?php

namespace Modules\User\app\Providers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\User\app\Models\Admin;
use Modules\User\app\Models\BlockedAccount;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
use Modules\User\app\Models\UserProfile;
use Modules\User\app\Repository\AdminEloquentRepository;
use Modules\User\app\Repository\BlockedAccountEloquentRepository;
use Modules\User\app\Repository\PasswordResetTokenEloquentRepository;
use Modules\User\app\Repository\UserProfileEloquentRepository;
use Modules\User\app\Repository\UserEloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, fn () => new UserEloquentRepository(new User()));
        $this->app->singleton(BlockedAccountEloquentRepository::class, fn () => new BlockedAccountEloquentRepository(new BlockedAccount()));
        $this->app->singleton(UserProfileEloquentRepository::class, fn () => new UserProfileEloquentRepository(new UserProfile()));
        $this->app->singleton(AdminEloquentRepository::class, fn () => new AdminEloquentRepository(new Admin()));
        $this->app->singleton(PasswordResetTokenEloquentRepository::class, fn () => new PasswordResetTokenEloquentRepository(new PasswordResetToken()));

    }
}
