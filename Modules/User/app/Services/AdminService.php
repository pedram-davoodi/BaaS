<?php

namespace Modules\User\app\Services;

use App\Events\AdminLoggedIn;
use App\Events\AdminRegistered;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Models\Admin;
use Modules\User\app\Repository\AdminRepository;

/**
 * Class AdminService
 */
class AdminService
{
    /**
     * Create a new admin.
     */
    public function createAdmin(string $name, string $password, string $email): Admin
    {
        $password = bcrypt($password);
        $admin = app(AdminRepository::class)->create([
            'name' => $name,
            'password' => $password,
            'email' => $email,
        ]);
        AdminRegistered::dispatch($admin);

        return $admin;
    }

    /**
     * Create access token for the admin.
     */
    public function createAccessToken(Admin $admin): PersonalAccessTokenResult
    {
        AdminLoggedIn::dispatch($admin);

        return $admin->createToken('Admin Access Token');
    }

    /**
     * Check admin credentials.
     */
    public function checkAdminCredential(string $email, string $password): bool
    {
        $admin = app(AdminRepository::class)->getFirstWhere(['email' => $email]);

        return ! empty($admin) && Hash::check($password, $admin->password);
    }
}
