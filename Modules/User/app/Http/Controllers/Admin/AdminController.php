<?php

namespace Modules\User\app\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\app\Http\Requests\AdminLoginRequest;
use Modules\User\app\Http\Requests\AdminRegisterRequest;
use Modules\User\app\Models\Admin;
use Modules\User\app\Resources\AdminLoginResource;
use Modules\User\app\Services\AdminService;
use Throwable;

/**
 * Class AdminController
 *
 * @package Modules\User\app\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    public function __construct(private readonly AdminService $adminService){}

    /**
     * Handles admin logins.
     *
     * @param AdminLoginRequest $request
     * @return AdminLoginResource
     * @throws Throwable
     */
    public function login(AdminLoginRequest $request): AdminLoginResource
    {
        throw_if(
            !$this->adminService->checkAdminCredential($request->email , $request->password),
            LoginWrongCredentialException::class,
            __("admin.login.wrongCredential")
        );

        $tokenResult = $this->adminService->createAccessToken(
            $admin = Admin::firstWhere('email', $request->get('email'))
        );

        return new AdminLoginResource($admin, $tokenResult);
    }

    /**
     * Register API for admin.
     *
     * @param AdminRegisterRequest $request
     * @return AdminLoginResource
     */
    public function register(AdminRegisterRequest $request): AdminLoginResource
    {
        $admin = $this->adminService->createAdmin($request->name , $request->password , $request->email);
        $token = $this->adminService->createAccessToken($admin);
        return new AdminLoginResource($admin, $token);
    }
}
