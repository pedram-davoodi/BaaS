<?php

namespace App\Repositories;

use App\Repositories\Base\RepositoryInterface;
use Laravel\Passport\PersonalAccessTokenResult;

interface AdminRepositoryInterface extends RepositoryInterface{

    /**
     * Create access token for the user.
     */
    public function createAccessToken($admin_id): PersonalAccessTokenResult;

    /**
     * Check user credentials.
     */
    public function checkUserCredential(string $email, string $password): bool;
}
