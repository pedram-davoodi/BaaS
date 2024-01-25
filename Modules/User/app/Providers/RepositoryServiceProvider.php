<?php

namespace Modules\User\app\Providers;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\BlockedAccountRepositoryInterface;
use App\Repositories\PasswordResetTokenRepositoryInterface;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
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
        $this->app->singleton(UserRepositoryInterface::class, fn () => new UserRepository(new User()));
        $this->app->singleton(BlockedAccountRepositoryInterface::class, fn () => new BlockedAccountRepository(new BlockedAccount()));
        $this->app->singleton(UserProfileRepositoryInterface::class, fn () => new UserProfileRepository(new UserProfile()));
        $this->app->singleton(AdminRepositoryInterface::class, fn () => new AdminRepository(new Admin()));
        $this->app->singleton(PasswordResetTokenRepositoryInterface::class, fn () => new PasswordResetTokenRepository(new PasswordResetToken()));
    }
}
