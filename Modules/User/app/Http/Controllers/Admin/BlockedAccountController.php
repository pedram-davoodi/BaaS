<?php

namespace Modules\User\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Modules\User\app\Http\Requests\StoreBlockedAccountRequest;
use Modules\User\app\Http\Services\BlockedAccountService;
use Modules\User\app\Models\BlockedAccount;
use Modules\User\app\Models\User;
use Modules\User\app\Repository\BlockedAccountRepository;
use Modules\User\app\Resources\BlockedAccountCollection;
use Modules\User\app\Resources\BlockedAccountResource;

class BlockedAccountController extends Controller
{
    /**
     * Display a listing of blocked accounts.
     *
     * @param BlockedAccountRepository $blockedAccountRepository
     * @return BlockedAccountCollection
     */
    public function index(BlockedAccountRepository $blockedAccountRepository): BlockedAccountCollection
    {
        return new BlockedAccountCollection($blockedAccountRepository->paginate(10));
    }

    /**
     * Store a newly created blocked account.
     *
     * @param StoreBlockedAccountRequest $request
     * @param BlockedAccountService $service
     * @return BlockedAccountResource
     * @throws Exception
     */
    public function store(StoreBlockedAccountRequest $request , BlockedAccountService $service): BlockedAccountResource
    {
        $blockedAccount = $service->block(
            User::find($request->user_id),
            $request->description,
            new DateTime($request->expired_at)
        );

        return new BlockedAccountResource($blockedAccount);
    }

    /**
     * Remove the specified blocked account.
     *
     * @param BlockedAccount $blockedAccount
     * @param BlockedAccountService $service
     * @return JsonResponse
     */
    public function destroy(BlockedAccount $blockedAccount , BlockedAccountService $service): JsonResponse
    {
        $service->unblock(User::find($blockedAccount->user_id));

        return jsonResponse(message:__('admin.user.unblocked'));
    }
}
