<?php

namespace Modules\User\app\Repository;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\BlockedAccountRepositoryInterface;

class BlockedAccountEloquentRepository extends EloquentRepository implements BlockedAccountRepositoryInterface
{}
