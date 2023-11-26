<?php

namespace Modules\User\app\Repository;

use App\Repositories\Repository;
use Modules\User\app\Models\UserProfile;

class UserProfileRepository extends Repository
{
    protected string $modelClass = UserProfile::class;
}
