<?php

namespace Modules\User\app\Repository;

use App\ModelInterfaces\Base\ModelInterface;
use App\Repositories\Base\EloquentRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Models\User;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getByEmails(array $emails): Collection
    {
        return $this->model->whereIn('email', $emails)->get();
    }

    /**
     * Create access token for the user.
     */
    public function createAccessToken($user_id): PersonalAccessTokenResult
    {
        return User::find($user_id)->createToken('User Access Token');
    }

    /**
     * Check user credentials.
     */
    public function checkUserCredential(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }
}
