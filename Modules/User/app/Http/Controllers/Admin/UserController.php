<?php

namespace Modules\User\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\UserRepository;
use Modules\User\app\Resources\UserCollection;
use Modules\User\app\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserRepository $repository): UserCollection
    {
        return new UserCollection($repository->paginate(5));
    }

    /**
     * display a specific user
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }
}
