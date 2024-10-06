<?php

namespace App\Repositories;

use App\Repositories\Base\RepositoryInterface;
use Illuminate\Support\Collection;
use Laravel\Passport\PersonalAccessTokenResult;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getByEmails(array $emails): Collection;

}
