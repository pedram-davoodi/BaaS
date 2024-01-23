<?php

namespace Modules\User\app\Repository;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\UserProfileRepositoryInterface;

class UserProfileEloquentRepository extends EloquentRepository implements UserProfileRepositoryInterface
{}
