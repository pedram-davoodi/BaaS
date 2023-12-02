<?php

namespace Modules\User\tests\Feature;

use Illuminate\Support\Facades\Hash;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;

/**
 * Test User\UserController
 */
class AuthTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => '123456',
        ]);
    }

    public function test_login_success(): void
    {
        $response = $this->post(route('user.user.users.login'), [
            'email' => 'test@test.com',
            'password' => '123456',
        ]);
        $response->assertOk();
        $response->assertSee('token');
    }

    public function test_login_fails(): void
    {
        $response = $this
            ->withHeaders($this->headers)
            ->post(route('user.user.users.login'), [
                'email' => 'test@test.com',
                'password' => '1234556',
            ]);

        $response->assertStatus(401);
        $response->assertSee('message');
    }

    public function test_register_success()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.register'), [
                'email' => 'ali@ali.com',
                'password' => '123456',
                'c_password' => '123456',
            ]);

        $response->assertOk();
        $response->assertSee(['data', 'token']);
    }

    public function test_register_fails()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.register'), [
                'email' => 'ali@ali.com',
                'password' => '1234546',
                'c_password' => '123456',
            ]);

        $response->assertJsonValidationErrors('c_password');
    }

    public function test_forget_password_success()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.forgetPassword'), [
                'email' => $this->user->email,
            ]);
        $response->assertOk();
        $response->assertSee('message');
    }

    public function test_forget_password_fails()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.forgetPassword'), [
                'email' => $this->user->email.'a',
            ]);
        $response->assertOk();
        $response->assertSee('message');
    }

    public function test_check_forget_password_token()
    {

        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.forgetPassword'), [
                'email' => $this->user->email,
            ]);
        $response->assertOk();
        $response->assertSee('message');

        $token = PasswordResetToken::first();

        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.checkForgetPasswordToken'), [
                'email' => $this->user->email,
                'token' => $token->token,
            ]);

        $response->assertOk();
        $response->assertSee(['data', 'valid']);
        $this->assertEquals(true, json_decode($response->getContent(), true)['data']['valid']);
    }

    public function test_check_forget_password_token_fail()
    {

        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.forgetPassword'), [
                'email' => $this->user->email,
            ]);
        $response->assertOk();
        $response->assertSee('message');

        $token = PasswordResetToken::first();

        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.checkForgetPasswordToken'), [
                'email' => $this->user->email,
                'token' => $token->token.'A',
            ]);

        $response->assertOk();
        $response->assertSee(['data', 'valid']);
        $this->assertEquals(false, json_decode($response->getContent(), true)['data']['valid']);
    }

    public function test_reset_password_success()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.forgetPassword'), [
                'email' => $this->user->email,
            ]);
        $response->assertOk();
        $response->assertSee('message');

        $token = PasswordResetToken::first();

        $response = $this->withHeaders($this->headers)
            ->put(route('user.user.users.resetPassword'), [
                'email' => $this->user->email,
                'token' => $token->token,
                'password' => '123456789',
                'c_password' => '123456789',
            ]);

        $response->assertOk();
        $response->assertSee('message');
        $this->assertTrue(Hash::check('123456789', User::first()->password));
    }

    public function test_reset_password_fails()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.user.users.forgetPassword'), [
                'email' => $this->user->email,
            ]);
        $response->assertOk();
        $response->assertSee('message');

        $token = PasswordResetToken::first();

        $response = $this->withHeaders($this->headers)
            ->put(route('user.user.users.resetPassword'), [
                'email' => $this->user->email,
                'token' => $token->token,
                'password' => '1234567891',
                'c_password' => '123456789',
            ]);

        $response->assertJsonValidationErrors('c_password');
        $response->assertSee('message');
        $this->assertTrue(Hash::check('123456', User::first()->password));
    }
}
