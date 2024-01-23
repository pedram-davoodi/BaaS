<?php

namespace Modules\User\app\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\app\Http\Requests\AdminLoginRequest;
use Modules\User\app\Http\Requests\AdminRegisterRequest;
use App\Repositories\AdminRepositoryInterface;
use Modules\User\app\Resources\AdminLoginResource;
use Modules\User\app\Services\AdminService;
use Throwable;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    public function __construct(private readonly AdminService $adminService)
    {
    }

    /**
     * Handles admin logins.
     *
     * @throws Throwable
     */
    public function login(AdminLoginRequest $request): AdminLoginResource
    {
        throw_if(
            ! $this->adminService->checkAdminCredential($request->email, $request->password),
            LoginWrongCredentialException::class,
            __('admin.login.wrongCredential')
        );
        $tokenResult = $this->adminService->createAccessToken($request->email);

        $admin = app(AdminRepositoryInterface::class)->getFirstWhere(['email' => $request->email]);
        return new AdminLoginResource($admin, $tokenResult);
    }

    /**
     * Register API for admin.
     */
    public function register(AdminRegisterRequest $request): AdminLoginResource
    {
        $admin = $this->adminService->createAdmin($request->name, $request->password, $request->email);
        $token = $this->adminService->createAccessToken($request->email);

        return new AdminLoginResource($admin, $token);
    }
}
