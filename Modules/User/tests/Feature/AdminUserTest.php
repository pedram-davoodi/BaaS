<?php

namespace Modules\User\tests\Feature;

use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Models\Admin;
use Modules\User\app\Models\User;
use Modules\User\app\Services\AdminService;
use Modules\User\app\Services\UserService;

class AdminUserTest extends TestCase
{
    const ROUTE = 'user.admin.users.';
    private string $adminToken;

    public function setUp(): void
    {
        $adminService = new AdminService();
        parent::setUp();
        $admin = $adminService->createAdmin('ali' , '123456' , 'admin@admin.com');
        $this->adminToken = $adminService->createAccessToken($admin)->accessToken;
    }

    public function test_user_create_success()
    {
        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->post(route(self::ROUTE.'store') , [
                'email' => 'Ali@ali.com',
                'password' => "123456",
                'c_password' => "123456"
            ]);

        $response->assertStatus(201)->assertSee('data')->assertSee('email');
    }

    public function test_user_create_fails()
    {
        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->post(route(self::ROUTE.'store') , [
                'email' => 'Ali@ali.com',
                'c_password' => "123456"
            ]);

        $response->assertJsonValidationErrors('password');
    }

    public function test_user_update_success()
    {
        (new UserService())->createUser('user@user.com' , '123456');

        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->put(route(self::ROUTE.'update' , 1) , [
                'password' => "123456",
                'c_password' => "123456"
            ]);

        $response->assertStatus(200)->assertSee('data')->assertSee('email');
    }

    public function test_user_update_fails()
    {
        (new UserService())->createUser('user@user.com' , '123456');

        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->put(route(self::ROUTE.'update' , 1) , [
                'password' => "123456",
            ]);

        $response->assertJsonValidationErrors('c_password');

    }

    public function test_user_index()
    {
        $US = new UserService();
        $US->createUser('user@user.com' , '123456');
        $US->createUser('user1@user.com' , '123456');
        $US->createUser('use2r@user.com' , '123456');
        $US->createUser('user3@user.com' , '123456');

        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->get(route(self::ROUTE.'index'));

        $response->assertOk()->assertSee('data');
    }

    public function test_user_show()
    {
        $US = new UserService();
        $US->createUser('user@user.com' , '123456');
        $US->createUser('user1@user.com' , '123456');
        $US->createUser('use2r@user.com' , '123456');
        $US->createUser('user3@user.com' , '123456');

        $response = $this->withHeaders($this->headers + ['Authorization' => 'Bearer '.$this->adminToken])
            ->get(route(self::ROUTE.'show' , 1));

        $response->assertOk()->assertSee('data');
    }
}
