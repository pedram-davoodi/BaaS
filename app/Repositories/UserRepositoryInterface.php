<?php

namespace App\Repositories;

use App\Repositories\Base\RepositoryInterface;
use Illuminate\Support\Collection;
use Laravel\Passport\PersonalAccessTokenResult;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getByEmails(array $emails): Collection;

    /**
     * Create access token for the user.
     */
    public function createAccessToken($user_id): PersonalAccessTokenResult;

    /**
     * Check user credentials.
     */
    public function checkUserCredential(string $email, string $password): bool;
}
