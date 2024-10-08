<?php

namespace Modules\User\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\app\Http\Requests\UpdateUserProfileRequest;
use App\Repositories\UserProfileRepositoryInterface;
use Modules\User\app\Resources\ProfileResource;
use Modules\User\app\Services\UserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class UserProfileController extends Controller
{
    /**
     * Show the user profile resource.
     * @throws Throwable
     */
    public function show(): ProfileResource
    {
        $profile = app(UserProfileRepositoryInterface::class)
            ->getFirstWhere('user_id', Auth::guard('api')->id());

        throw_if(empty($profile) , NotFoundHttpException::class);

        return new ProfileResource($profile);
    }

    /**
     * Update the user profile in storage.
     */
    public function update(UpdateUserProfileRequest $request, UserService $service): ProfileResource
    {
        return new ProfileResource(
            $service->updateProfile(
                Auth::guard('api')->id(),
                $request->first_name,
                $request->last_name,
                $request->mobile,
                $request->address
            )
        );
    }
}
