<?php

namespace Modules\Cart\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\app\Http\Requests\StoreCartRequest;
use Modules\Cart\app\Resources\CartResource;
use Modules\Cart\app\Rules\CartableTypeValidation;
use Modules\Cart\app\Services\CartService;

class CartController extends Controller
{
    /**
     * Store a newly created cart in storage.
     */
    public function store(StoreCartRequest $request , CartService $cartService): CartResource
    {
        $cart = $cartService->addNewItem($request->cartable_id , $request->cartable_type , $request->quantity);
        return new CartResource($cart);
    }

    /**
     * Show the specified resource.
     */
    public function show(CartRepositoryInterface $cartRepository): CartResource
    {
        $cart = $cartRepository->getFirstWhere(['user_id' => Auth::id()]);
        return new CartResource($cart);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
