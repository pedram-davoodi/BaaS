<?php

namespace Modules\User\app\Repository\Eloquent;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\Base\EloquentRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Models\Admin;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{
    /**
     * Create access token for the user.
     */
    public function createAccessToken($admin_id): PersonalAccessTokenResult
    {
        return Admin::find($admin_id)->createToken('User Access Token');
    }

    /**
     * Check user credentials.
     */
    public function checkUserCredential(string $email, string $password): bool
    {
        $admin = app(AdminRepository::class)->getFirstWhere(['email' => $email]);

        return ! empty($admin) && Hash::check($password, $admin->password);
    }
}
