<?php

namespace Modules\User\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\app\Models\User;
use Modules\User\app\Services\UserService;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => '123456',
        ]);
        $token = (new UserService())->createAccessToken($this->user)->accessToken;
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
        $this->user->userProfile()->create([
            'first_name' => 'Ali',
            'last_name' => 'Davoodi',
            'mobile' => '09307718864',
            'address' => 'Mashhad',
        ]);

        $response = $this->withHeaders($this->headers)
            ->get(route('user.user.profiles.show'));

        $response->assertSee('data')->assertOk();
    }
}
