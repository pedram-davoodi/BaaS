<?php

namespace Modules\User\app\Services;

use App\Events\ForgetPassword;
use App\Events\UserAccountBlocked;
use App\Events\UserAccountUnblocked;
use App\Events\UserLoggedIn;
use App\Events\UserPasswordWasRest;
use App\Events\UserProfileUpdated;
use App\Events\UserRegistered;
use App\Events\UserUpdated;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\app\Models\BlockedAccount;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
use Modules\User\app\Models\UserProfile;
use Throwable;

/**
 * Class UserService
 *
 * @package Modules\User\app\Services
 */
class UserService
{
    /**
     * Create a new user.
     *
     * @param string $email
     * @param string $password
     * @return User
     */
    public function createUser(string $email , string $password): User
    {
        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password)
        ]);
        UserRegistered::dispatch($user);
        return $user;
    }


    /**
     * update an existing user.
     *
     * @param User $user
     * @param string $password
     * @return User
     */
    public function updateUser(User $user , string $password): User
    {
        $user->update([
            'password' => bcrypt($password)
        ]);
        UserUpdated::dispatch($user);
        return $user;
    }

    /**
     * Create access token for the user.
     *
     * @param User $user
     * @return PersonalAccessTokenResult
     */
    public function createAccessToken(User $user): PersonalAccessTokenResult
    {
        UserLoggedIn::dispatch($user);
        return $user->createToken('User Access Token');
    }

    /**
     * Check user credentials.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkUserCredential(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }

    /**
     * Initiate the forget password process.
     *
     * @param string $email
     * @throws LoginWrongCredentialException|Throwable
     */
    public function forgetPassword(string $email): void
    {
        $user = User::firstWhere('email', $email);

        if (empty($user))
            return;

        PasswordResetToken::updateOrCreate(['email' => $email], ['token' => $token = Hash::make(Str::random(32))]);

        ForgetPassword::dispatch($user, $token);
    }

    /**
     * Reset the user's password and dispatch an event.
     *
     * @param User $user The user for whom the password will be reset.
     * @param string $newPassword The new password for the user.
     * @return void
     */
    public function resetPassword(User $user, string $newPassword): void
    {
        $user->update(['password' => bcrypt($newPassword)]);
        PasswordResetToken::find($user->email)->delete();
        UserPasswordWasRest::dispatch($user);
    }

    /**
     * Block the user's account.
     *
     * @param User $user
     * @param string $description
     * @param DateTime $expired_at
     * @return BlockedAccount
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
     */
    public function unblock(User $user): User
    {
        $user->blockedAccount()->delete();
        UserAccountUnblocked::dispatch($user);
        return $user;
    }


    /**
     * Update a user profile
     *
     * @param User $user
     * @param string $firstName
     * @param string $lastName
     * @param string $mobile
     * @param string $address
     * @return UserProfile
     */
    public function updateProfile(User $user , string $firstName, string $lastName, string $mobile, string $address): UserProfile
    {
        $userProfile = $user->userProfile()->updateOrCreate(['user_id' => $user->id] ,
            [
                "first_name" => $firstName,
                "last_name" => $lastName,
                "mobile" => $mobile,
                "address" => $address,
            ]);
        UserProfileUpdated::dispatch($userProfile);

        return $userProfile;
    }

}
