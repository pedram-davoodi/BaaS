<?php

namespace Modules\User\app\Repository\Eloquent;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\PasswordResetTokenRepositoryInterface;

class PasswordResetTokenRepository extends EloquentRepository implements PasswordResetTokenRepositoryInterface
{}
