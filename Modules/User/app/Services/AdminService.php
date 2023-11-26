<?php

namespace Modules\User\app\Services;

use App\Events\AdminLoggedIn;
use App\Events\AdminRegistered;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
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
     * @param string $name
     * @param string $password
     * @param string $email
     * @return Admin
     */
    public function createAdmin(string $name , string $password , string $email): Admin
    {
        $password = bcrypt($password);
        $admin = Admin::create([
            'name' => $name,
            'password' => $password,
            'email' => $email,
        ]);
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
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkAdminCredential(string $email , string $password): bool
    {
        $admin = Admin::firstWhere('email', $email);
        return !empty($admin) && Hash::check($password, $admin->password);
    }
}
