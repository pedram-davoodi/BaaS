<?php

namespace Modules\User\tests\Feature;

use Modules\User\app\Services\AdminService;

class AdminAuthTest extends TestCase
{
    public function test_admin_register_success()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.admin.admins.register'), [
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'password' => '123456',
                'c_password' => '123456',
            ]);

        $response->assertOk()->assertSee('data')->assertSee('token');
    }

    public function test_admin_register_fails()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.admin.admins.register'), [
                'name' => 'Ali',
                'password' => '123456',
                'c_password' => '123456',
            ]);

        $response->assertJsonValidationErrors('email');
    }

    public function test_admin_register_password_fails()
    {
        $response = $this->withHeaders($this->headers)
            ->post(route('user.admin.admins.register'), [
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'password' => '1234546',
                'c_password' => '123456',
            ]);

        $response->assertJsonValidationErrors('c_password');
    }

    public function test_admin_login_success()
    {
        $admin = (new AdminService())->createAdmin('Ali', '137613', 'eamil@aa.com');

        $respnose = $this->withHeaders($this->headers)->post(route('user.admin.admins.login', [
            'email' => 'eamil@aa.com',
            'password' => '137613',
        ]));

        $respnose->assertOk()->assertSee('token');
    }

    public function test_admin_login_fails()
    {
        $admin = (new AdminService())->createAdmin('Ali', '137613', 'eamil@aa.com');

        $respnose = $this->withHeaders($this->headers)->post(route('user.admin.admins.login', [
            'email' => 'eamil@aa.cosm',
            'password' => '137613',
        ]));

        $respnose->assertStatus(401)->assertSee('message');
    }
}
