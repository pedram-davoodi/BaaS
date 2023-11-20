<?php

namespace Modules\User\app\Services;

use App\Events\ForgetPassword;
use App\Events\UserLoggedIn;
use App\Events\UserPasswordWasRest;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\PersonalAccessTokenResult;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\app\Http\Requests\LoginRequest;
use Modules\User\app\Http\Requests\RegisterRequest;
use Modules\User\app\Models\PasswordResetToken;
use Modules\User\app\Models\User;
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
     * @param RegisterRequest $request
     * @return User
     */
    public function createUser(RegisterRequest $request): User
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        UserRegistered::dispatch($user);
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
     * @param LoginRequest $request
     * @return bool
     */
    public function checkUserCredential(LoginRequest $request): bool
    {
        $credentials = request(['email', 'password']);
        return Auth::attempt($credentials);
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
}
