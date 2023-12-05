<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getByEmails(array $emails): Collection;
}
