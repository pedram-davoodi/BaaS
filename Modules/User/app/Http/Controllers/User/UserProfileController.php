<?php

namespace Modules\User\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\app\Http\Requests\UpdateUserProfileRequest;
use Modules\User\app\Models\User;
use Modules\User\app\Models\UserProfile;
use Modules\User\app\Repository\UserProfileRepository;
use Modules\User\app\Resources\ProfileResource;
use Modules\User\app\Services\UserService;

class UserProfileController extends Controller
{
    /**
     * Show the user profile resource.
     */
    public function show(): ProfileResource
    {
        return new ProfileResource((new UserProfileRepository(new UserProfile()))
            ->getFirstWhere('user_id', Auth::guard('api')->id()));
    }

    /**
     * Update the user profile in storage.
     */
    public function update(UpdateUserProfileRequest $request, UserService $service): ProfileResource
    {
        return new ProfileResource(
            $service->updateProfile(
                User::find(Auth::guard('api')->id()),
                $request->first_name,
                $request->last_name,
                $request->mobile,
                $request->address
            )
        );
    }
}
