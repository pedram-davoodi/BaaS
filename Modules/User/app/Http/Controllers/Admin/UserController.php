<?php

namespace Modules\User\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\User\app\Repository\UserRepository;
use Modules\User\app\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserRepository $repository)
    {
        return new UserCollection($repository->paginate(5));
    }
}
