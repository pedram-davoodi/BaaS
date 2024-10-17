<?php

namespace Modules\Cart\app\Rules;

use App\Repositories\CartRepositoryInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CartableExistsValidation implements ValidationRule,DataAwareRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $repository = app()->make(CartRepositoryInterface::class);
            $cart = $repository->getFirstWhere(['user_id' => Auth::id()]);

            $exists = collect(json_decode($cart->items, true))
                ->where('cartable_id' , $this->data['cartable_id'])
                ->where('cartable_type' , $this->data['cartable_type'])->isNotEmpty();
            if (!$exists){
                $fail("product dose not exits in cart");
            }
        }catch (\Exception $exception){
            $fail("product dose not exits in cart");
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
