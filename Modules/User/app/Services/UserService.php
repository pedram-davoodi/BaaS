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
use App\ModelInterfaces\BlockedAccountModelInterface;
use App\ModelInterfaces\UserModelInterface;
use App\ModelInterfaces\UserProfileModelInterface;
use App\Repositories\BlockedAccountRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use App\Repositories\PasswordResetTokenRepositoryInterface;
use Throwable;
use App\Repositories\UserProfileRepositoryInterface;

/**
 * Class UserService
 */
class UserService
{
    /**
     * Create a new user.
     */
    public function createUser(string $email, string $password): UserModelInterface
    {
        $user = app(UserRepositoryInterface::class)->create([
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        UserRegistered::dispatch($user);

        return $user;
    }

    /**
     * update an existing user.
     */
    public function updateUser(int $user_id, string $password): UserModelInterface
    {
        $user = app(UserRepositoryInterface::class)->getOneById($user_id);
        app(UserRepositoryInterface::class)->update(['password' => bcrypt($password)] , ['id' => $user_id]);
        UserUpdated::dispatch($user);
        return $user;
    }

    /**
     * Create access token for the user.
     */
    public function createAccessToken($user_id): PersonalAccessTokenResult
    {
        $user = app(UserRepositoryInterface::class)->getOneById($user_id);
        UserLoggedIn::dispatch($user);
        return app(UserRepositoryInterface::class)->createAccessToken($user_id);
    }

    /**
     * Check user credentials.
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
     * @throws LoginWrongCredentialException|Throwable
     */
    public function forgetPassword(string $email): void
    {
        $user = app(UserRepositoryInterface::class)->getByEmails([$email])->first();

        if (empty($user)) {
            return;
        }

        app(PasswordResetTokenRepositoryInterface::class)->updateOrCreate(['email' => $email], ['token' => $token = Hash::make(Str::random(32))]);

        ForgetPassword::dispatch($user, $token);
    }

    /**
     * Reset the user's password and dispatch an event.
     *
     * @param $user_id
     * @param string $newPassword The new password for the user.
     */
    public function resetPassword($user_id, string $newPassword): void
    {
        $user = app(UserRepositoryInterface::class)->getOneById($user_id);
        app(UserRepositoryInterface::class)->update(['password' => bcrypt($newPassword)] , ['id' => $user_id]);
        app(PasswordResetTokenRepositoryInterface::class)->getOneById($user->email)->delete();
        UserPasswordWasRest::dispatch($user);
    }

    /**
     * Block the user's account.
     *
     * @return BlockedAccountModelInterface
     */
    public function block($user_id, string $description, DateTime $expired_at): Model
    {
        $blockedAccount = app(BlockedAccountRepositoryInterface::class)->updateOrCreate(
            ['user_id' => $user_id],
            ['description' => $description, 'expired_at' => $expired_at]
        );
        $user = app(UserRepositoryInterface::class)->getOneById($user_id);

        UserAccountBlocked::dispatch($user, $blockedAccount);

        return $blockedAccount;
    }

    /**
     * Unblock the user's account.
     */
    public function unblock($user_id): UserModelInterface
    {
        $user = app(UserRepositoryInterface::class)->getOneById($user_id);
        app(BlockedAccountRepositoryInterface::class)->delete(['user_id' => $user_id]);
        UserAccountUnblocked::dispatch($user);
        return $user;
    }

    /**
     * Update a user profile
     */
    public function updateProfile(int $user_id, string $firstName, string $lastName, string $mobile, string $address): UserProfileModelInterface
    {
        $userProfile = app(UserProfileRepositoryInterface::class)->updateOrCreate(['user_id' => $user_id],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'mobile' => $mobile,
                'address' => $address,
            ]);
        UserProfileUpdated::dispatch($userProfile);
        return $userProfile;
    }
}
