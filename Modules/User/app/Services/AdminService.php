<?php

namespace Modules\User\app\Services;

use App\Events\AdminLoggedIn;
use App\Events\AdminRegistered;
use App\ModelInterfaces\AdminModelInterface;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use App\Repositories\AdminRepositoryInterface;

/**
 * Class AdminService
 */
class AdminService
{
    /**
     * Create a new admin.
     */
    public function createAdmin(string $name, string $password, string $email): AdminModelInterface
    {
        $password = bcrypt($password);
        $admin = app(AdminRepositoryInterface::class)->create([
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
    public function createAccessToken(string $email): PersonalAccessTokenResult
    {
        $admin = app(AdminRepositoryInterface::class)->getFirstWhere(['email' => $email]);
        AdminLoggedIn::dispatch($admin);
        return $admin->createToken('User Access Token');
    }

    /**
     * Check admin credentials.
     */
    public function checkAdminCredential(string $email, string $password): bool
    {
        $admin = app(AdminRepositoryInterface::class)->getFirstWhere(['email' => $email]);

        return ! empty($admin) && Hash::check($password, $admin->password);
    }
}
