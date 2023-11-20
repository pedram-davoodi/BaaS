<?php

namespace Modules\User\app\Http\Services;

use App\Events\ForgetPassword;
use App\Events\UserRegistered;
use App\Events\UserLoggedIn;
use Illuminate\Support\Facades\Auth;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\App\Exceptions\UserNotFoundException;
use Modules\User\app\Http\Requests\LoginRequest;
use Modules\User\app\Http\Requests\RegisterRequest;
use Modules\User\app\Models\User;

class UserService
{
    public function createUser(RegisterRequest $request)
    {// Create a new user
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Dispatch register event
        UserRegistered::dispatch($user);

        return $user;
    }

    public function createAccesToken(User $user)
    {
        UserLoggedIn::dispatch($user);
        return $user->createToken('MyApp');
    }

    public function checkuserCredential(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        return Auth::attempt($credentials);
    }

    public function forgetPassword(string $email): void
    {
        $user = User::firstWhere('email' , $email);
        throw_if(empty($user) , LoginWrongCredentialException::class);
        ForgetPassword::dispatch($user);
    }
}
