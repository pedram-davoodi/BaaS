<?php

namespace Modules\User\app\Repository\Eloquent;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Models\User;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getByEmails(array $emails): Collection
    {
        return $this->model->whereIn('email', $emails)->get();
    }
}
