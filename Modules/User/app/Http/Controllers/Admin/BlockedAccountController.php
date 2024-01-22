<?php

namespace Modules\User\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\User\app\Http\Requests\StoreBlockedAccountRequest;
use Modules\User\app\Models\BlockedAccount;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\BlockedAccountEloquentRepository;
use Modules\User\app\Resources\BlockedAccountCollection;
use Modules\User\app\Resources\BlockedAccountResource;
use Modules\User\app\Services\UserService;

class BlockedAccountController extends Controller
{
    /**
     * Display a listing of blocked accounts.
     */
    public function index(): BlockedAccountCollection
    {
        return new BlockedAccountCollection((new BlockedAccountEloquentRepository(new BlockedAccount()))
            ->paginate(10));
    }

    /**
     * Store a newly created blocked account.
     *
     * @throws Exception
     */
    public function store(StoreBlockedAccountRequest $request, UserService $service): BlockedAccountResource
    {
        $blockedAccount = $service->block(
            $request->user_id,
            $request->description,
            new DateTime($request->expired_at)
        );

        return new BlockedAccountResource($blockedAccount);
    }

    /**
     * Remove the specified blocked account.
     */
    public function destroy(BlockedAccount $blockedAccount, UserService $service): JsonResponse
    {
        $service->unblock($blockedAccount->user_id);

        return jsonResponse(message: __('admin.user.unblocked'));
    }
}
