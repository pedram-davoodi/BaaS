<?php

namespace Modules\User\app\Repository;

use App\Repositories\Repository;
use Modules\User\app\Models\User;

class UserRepository extends Repository
{
    protected string $modelClass = User::class;
}
