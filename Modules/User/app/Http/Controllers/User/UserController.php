<?php

namespace Modules\User\app\Http\Controllers\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\User\app\Exceptions\LoginWrongCredentialException;
use Modules\User\app\Http\Requests\ForgetPasswordRequest;
use Modules\User\app\Http\Requests\LoginRequest;
use Modules\User\app\Http\Requests\RegisterRequest;
use Modules\User\app\Http\Requests\RestPasswordRequest;
use Modules\User\app\Models\User;
use Modules\User\app\Resources\LoginResource;
use Modules\User\app\Rules\ForgetPasswordTokenBelongsToEmailRule;
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
        $token = $this->userService->createAccessToken($user);
        return new LoginResource($user, $token);
    }

    /**
     * Initiate the forget password process.
     *
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        $this->userService->forgetPassword($request->get('email'));

        return jsonResponse(message: __('user.forgetPassword.success'));
    }

    /**
     * Check the validity of a forget password token against the provided email.
     *
     * @param Request $request The incoming request.
     * @return JsonResponse The JSON response indicating token validity.
     */
    public function checkForgetPasswordToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->toArray() , [
            'email' => 'required|string|email',
            'token' => ['required' , new ForgetPasswordTokenBelongsToEmailRule($request->get('email'))],
        ]);

        return jsonResponse(data: ['valid' => $validator->passes()]);
    }

    /**
     * Reset user's password.
     *
     * @param RestPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(RestPasswordRequest $request): JsonResponse
    {
        $user = User::firstWhere('email' , $request->get('email'));
        $this->userService->resetPassword($user , $request->get('password'));

        return jsonResponse(message: __('user.resetPassword.success'));
    }
}
