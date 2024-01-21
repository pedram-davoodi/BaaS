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
use App\Repositories\UserRepositoryInterface;
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
use Modules\User\app\Repository\BlockedAccountRepository;
use Modules\User\app\Repository\UserProfileRepository;
use Throwable;

/**
 * Class UserService
 */
class UserService
{
    /**
     * Create a new user.
     */
    public function createUser(string $email, string $password): Model
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
    public function updateUser(User $user, string $password): User
    {

        app(UserRepositoryInterface::class)->update(['password' => bcrypt($password)] , ['id' => $user->id]);
        UserUpdated::dispatch($user);

        return $user;
    }

    /**
     * Create access token for the user.
     */
    public function createAccessToken(User $user): PersonalAccessTokenResult
    {
        UserLoggedIn::dispatch($user);

        return $user->createToken('User Access Token');
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

        PasswordResetToken::updateOrCreate(['email' => $email], ['token' => $token = Hash::make(Str::random(32))]);

        ForgetPassword::dispatch($user, $token);
    }

    /**
     * Reset the user's password and dispatch an event.
     *
     * @param  User  $user The user for whom the password will be reset.
     * @param  string  $newPassword The new password for the user.
     */
    public function resetPassword(User $user, string $newPassword): void
    {
        app(UserRepositoryInterface::class)->update(['password' => bcrypt($newPassword)] , ['id' => $user->id]);
        PasswordResetToken::find($user->email)->delete();
        UserPasswordWasRest::dispatch($user);
    }

    /**
     * Block the user's account.
     *
     * @return BlockedAccount
     */
    public function block(User $user, string $description, DateTime $expired_at): Model
    {
        $blockedAccount = app(BlockedAccountRepository::class)->updateOrCreate(
            ['user_id' => $user->id],
            ['description' => $description, 'expired_at' => $expired_at]
        );

        UserAccountBlocked::dispatch($user, $blockedAccount);

        return $blockedAccount;
    }

    /**
     * Unblock the user's account.
     */
    public function unblock(User $user): User
    {
        app(BlockedAccountRepository::class)->delete(['user_id' => $user->id]);
        UserAccountUnblocked::dispatch($user);

        return $user;
    }

    /**
     * Update a user profile
     */
    public function updateProfile(User $user, string $firstName, string $lastName, string $mobile, string $address): UserProfile
    {
        $userProfile = app(UserProfileRepository::class)->updateOrCreate(['user_id' => $user->id],
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
