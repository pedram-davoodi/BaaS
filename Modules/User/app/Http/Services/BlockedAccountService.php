<?php

namespace Modules\User\app\Http\Services;

use App\Events\UserAccountBlocked;
use App\Events\UserAccountUnblocked;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Modules\User\app\Models\User;

class BlockedAccountService
{
    /**
     * Block the user's account.
     *
     * @param User $user
     * @param string $description
     * @param DateTime $expired_at
     * @return Model
     */
    public function block(User $user , string $description , DateTime $expired_at): Model
    {
        $blockedAccount = $user->blockedAccount()->updateOrCreate(['user_id' => $user->id] ,
            [
                'description' => $description,
                'expired_at' => $expired_at
            ]);

        UserAccountBlocked::dispatch($user , $blockedAccount);
        return $blockedAccount;
    }

    /**
     * Unblock the user's account.
     *
     * @param User $user
     * @return User
     */
    public function unblock(User $user): User
    {
        $user->blockedAccount()->delete();
        UserAccountUnblocked::dispatch($user);
        return $user;
    }
}
