<?php

namespace Modules\Cart\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function show($id)
    {
        return view('cart::show');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
