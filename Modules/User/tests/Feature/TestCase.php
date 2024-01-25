<?php

namespace Modules\User\tests\Feature;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\Eloquent\PasswordResetTokenRepository;
use Modules\User\app\Repository\Eloquent\UserRepository;

class TestCase extends \Tests\TestCase
{
    use RefreshDatabase;

    protected array $headers = ['accept' => 'application/json'];

    protected UserRepositoryInterface  $userRepository;
    protected PasswordResetTokenRepository  $PasswordResetTokenEloquentRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(new User());
        $this->PasswordResetTokenEloquentRepository = (new PasswordResetTokenRepository(new PasswordResetToken()));

        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }
}
