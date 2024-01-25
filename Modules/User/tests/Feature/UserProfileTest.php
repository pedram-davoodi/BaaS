<?php

namespace Modules\User\tests\Feature;

use App\ModelInterfaces\Base\ModelInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\app\Services\UserService;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    private ModelInterface $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->userRepository->faker()->create([
            'email' => 'test@test.com',
            'password' => '123456',
        ]);
        $token = (new UserService())->createAccessToken($this->user->id)->accessToken;
        $this->headers['Authorization'] = 'Bearer '.$token;
    }

    public function test_user_profiles_update_success()
    {
        $response = $this->withHeaders($this->headers)
            ->put(route('user.user.profiles.update'), [
                'first_name' => 'Ali',
                'last_name' => 'Davoodi',
                'mobile' => '09307718864',
                'address' => 'Mashhad',
            ]);

        $response->assertStatus(201)->assertSee('data', 'first_name');
    }

    public function test_user_profiles_update_failed()
    {
        $response = $this->withHeaders($this->headers)
            ->put(route('user.user.profiles.update'), [
                'first_name' => 'Ali',
                'last_name' => 'Davoodi',
                'mobile' => '09307718864',
            ]);

        $response->assertJsonValidationErrors('address');
    }

    public function test_user_profiles_show()
    {
        $this->userProfileRepositoryInterface->faker()->create([
            'first_name' => 'Ali',
            'last_name' => 'Davoodi',
            'mobile' => '09307718864',
            'address' => 'Mashhad',
            'user_id' => $this->user->id
        ]);

        $response = $this->withHeaders($this->headers)
            ->get(route('user.user.profiles.show'));

        $response->assertSee('data')->assertOk();
    }
}
