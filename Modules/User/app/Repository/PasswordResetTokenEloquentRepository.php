<?php

namespace Modules\User\app\Repository;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\PasswordResetTokenRepositoryInterface;

class PasswordResetTokenEloquentRepository extends EloquentRepository implements PasswordResetTokenRepositoryInterface
{}
