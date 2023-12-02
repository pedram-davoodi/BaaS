<?php

namespace Modules\User\tests\Feature;

use Carbon\Carbon;
use Modules\User\app\Services\AdminService;
use Modules\User\app\Services\UserService;

class AdminBlockedAccountTest extends TestCase
{
    const ROUTE = 'user.admin.blocked-accounts.';

    public function setUp(): void
    {
        $adminService = new AdminService();
        parent::setUp();
        $admin = $adminService->createAdmin('ali' , '123456' , 'admin@admin.com');
        $adminToken = $adminService->createAccessToken($admin)->accessToken;
        $this->headers += ['Authorization' => 'Bearer '. $adminToken];

        $this->US = new UserService();
        $this->user = $this->US->createUser('user@user.com' , '123456');

    }

    public function test_blocked_account_create_success(){
        $response = $this->withHeaders($this->headers)->post(route(self::ROUTE.'store') , [
            'user_id' => $this->user->id ,
            'description' => "Test",
            'expires_at' => Carbon::tomorrow(),
        ]);

        $response->assertStatus(201)->assertSee('data');
    }

    public function test_blocked_account_create_fails(){
        $response = $this->withHeaders($this->headers)->post(route(self::ROUTE.'store') , [
            'description' => "Test",
            'expires_at' => Carbon::tomorrow(),
        ]);

        $response->assertJsonValidationErrors('user_id');
    }

    public function test_blocked_account_destroy_success(){
        $this->US->block($this->user , 'Test' , Carbon::tomorrow());
        $response = $this->withHeaders($this->headers)->delete(route(self::ROUTE.'destroy' , $this->user->id));

        $response->assertOk()->assertSee('message');
    }

    public function test_blocked_account_destroy_fails(){
        $response = $this->withHeaders($this->headers)->delete(route(self::ROUTE.'destroy' , $this->user->id));
        $response->assertNotFound();
    }

    public function test_blocked_account_index(){
        $response = $this->withHeaders($this->headers)->get(route(self::ROUTE.'index'));
        $response->assertOk()->assertSee('data');
    }
}

