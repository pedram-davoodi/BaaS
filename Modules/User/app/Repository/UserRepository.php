<?php

namespace Modules\User\app\Repository;

use App\Repositories\Repository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Modules\User\app\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected string $modelClass = User::class;

    public function getByEmails(array $emails): Collection
    {
        return $this->model->whereIn('email', $emails)->get();

    }
}
