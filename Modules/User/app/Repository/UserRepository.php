<?php

namespace Modules\User\app\Repository;

use App\Repositories\Base\Repository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function getByEmails(array $emails): Collection
    {
        return $this->model->whereIn('email', $emails)->get();
    }
}
