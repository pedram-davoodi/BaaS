<?php

namespace Modules\User\app\Repository;

use App\Repositories\Repository;
use App\Repositories\UserRepositoryInterface;
use Modules\User\app\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected string $modelClass = User::class;
}
