<?php

namespace Modules\User\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Modules\User\app\Http\Requests\RegisterRequest;
use Modules\User\app\Http\Requests\UpdateUserRequest;
use Modules\User\app\Resources\UserCollection;
use Modules\User\app\Resources\UserResource;
use Modules\User\app\Services\UserService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserRepositoryInterface $repository): UserCollection
    {
        return new UserCollection($repository->paginate(5));
    }

    /**
     * Display a specific user.
     */
    public function show(int $user_id): UserResource
    {
        return new UserResource(app(UserRepositoryInterface::class)->getOneByIdOrFail($user_id));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(RegisterRequest $request, UserService $userService): UserResource
    {
        return new UserResource($userService->createUser($request->email, $request->password));
    }

    /**
     * Update the specified user in storage.
     */
    public function update($user_id, UpdateUserRequest $request, UserService $userService): UserResource
    {
        return new UserResource($userService->updateUser($user_id, $request));
    }
}
