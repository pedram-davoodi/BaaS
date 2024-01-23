<?php

namespace Modules\Email\app\Providers;

use App\Repositories\EmailRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\Email\app\Models\Email;
use Modules\Email\app\Repository\EmailEloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(EmailRepositoryInterface::class, fn () => new EmailEloquentRepository(new Email()));
    }
}
