<?php

namespace Modules\User\app\Http\Controllers\User;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\app\Http\Requests\ForgetPasswordRequest;
use Modules\User\app\Http\Requests\LoginRequest;
use Modules\User\app\Http\Requests\RegisterRequest;
use Modules\User\app\Resources\LoginResource;
use Modules\User\app\Services\UserService;
use Throwable;

/**
 * Class UserController
 *
 * @package Modules\User\app\Http\Controllers\User
 */
class UserController extends Controller
{
    public function __construct(public UserService $userService){}

    /**
     * Handles user logins.
     *
     * @param LoginRequest $request
     * @return LoginResource
     * @throws Throwable
     */
    public function login(LoginRequest $request): LoginResource
    {
        throw_if(!$this->userService->checkUserCredential($request), LoginWrongCredentialException::class);
        $tokenResult = $this->userService->createAccessToken($request->user());
        return new LoginResource($request->user(), $tokenResult);
    }

    /**
     * Register API.
     *
     * @param RegisterRequest $request
     * @return LoginResource
     */
    public function register(RegisterRequest $request): LoginResource
    {
        $user = $this->userService->createUser($request);
        $token = $this->userService->createAccesToken($user);
        return new LoginResource($request->user(), $token);
    }

    /**
     * Initiate the forget password process.
     *
     * @param ForgetPasswordRequest $request
     * @return Response
     * @throws Throwable
     */
    public function forgetPassword(ForgetPasswordRequest $request): Response
    {
        $this->userService->forgetPassword($request->email);
        return response()->noContent();
    }

    /**
     * Reset user's password.
     *
     * @return void
     */
    public function resetPassword()
    {

    }
}
