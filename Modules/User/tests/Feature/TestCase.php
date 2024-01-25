<?php

namespace Modules\User\tests\Feature;

use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
use Modules\User\app\Models\UserProfile;
use Modules\User\app\Repository\Eloquent\PasswordResetTokenRepository;
use Modules\User\app\Repository\Eloquent\UserProfileRepository;
use Tests\TestCase as BaseTestCase;
use Modules\User\app\Repository\Eloquent\UserRepository;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected array $headers = ['accept' => 'application/json'];

    protected UserRepositoryInterface  $userRepository;
    protected PasswordResetTokenRepository  $passwordResetTokenRepository;
    protected UserProfileRepositoryInterface  $userProfileRepositoryInterface;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository(new User());
        $this->passwordResetTokenRepository = (new PasswordResetTokenRepository(new PasswordResetToken()));
        $this->userProfileRepositoryInterface = (new UserProfileRepository(new UserProfile()));

        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }
}
