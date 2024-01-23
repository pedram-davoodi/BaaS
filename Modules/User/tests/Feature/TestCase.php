<?php

namespace Modules\User\tests\Feature;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\PasswordResetTokenEloquentRepository;
use Modules\User\app\Repository\UserEloquentRepository;

class TestCase extends \Tests\TestCase
{
    use RefreshDatabase;

    protected array $headers = ['accept' => 'application/json'];

    protected UserRepositoryInterface  $userRepository;
    protected PasswordResetTokenEloquentRepository  $PasswordResetTokenEloquentRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserEloquentRepository(new User());
        $this->PasswordResetTokenEloquentRepository = (new PasswordResetTokenEloquentRepository(new PasswordResetToken()));

        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }
}
