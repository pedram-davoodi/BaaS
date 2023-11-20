<?php

namespace Modules\User\app\Services;

use App\Events\AdminLoggedIn;
use App\Events\AdminRegistered;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Http\Requests\AdminLoginRequest;
use Modules\User\app\Http\Requests\AdminRegisterRequest;
use Modules\User\app\Models\Admin;

/**
 * Class AdminService
 *
 * @package Modules\User\app\Services
 */
class AdminService
{
    /**
     * Create a new admin.
     *
     * @param AdminRegisterRequest $request
     * @return Admin
     */
    public function createAdmin(AdminRegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $admin = Admin::create($input);
        AdminRegistered::dispatch($admin);
        return $admin;
    }

    /**
     * Create access token for the admin.
     *
     * @param Admin $admin
     * @return PersonalAccessTokenResult
     */
    public function createAccessToken(Admin $admin): PersonalAccessTokenResult
    {
        AdminLoggedIn::dispatch($admin);
        return $admin->createToken('Admin Access Token');
    }

    /**
     * Check admin credentials.
     *
     * @param AdminLoginRequest $request
     * @return bool
     */
    public function checkAdminCredential(AdminLoginRequest $request): bool
    {
        $credentials = request(['email', 'password']);
        $admin = Admin::firstWhere('email', $credentials['email']);
        return !empty($admin) && Hash::check($credentials['password'], $admin->password);
    }
}
