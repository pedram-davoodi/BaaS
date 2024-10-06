<?php

namespace Modules\User\app\Repository\Eloquent;

use App\Repositories\AdminRepositoryInterface;
use App\Repositories\Base\EloquentRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Models\Admin;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{
}
