<?php

namespace Modules\Cart\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Cart\app\Rules\CartableIdValidation;
use Modules\Cart\app\Rules\CartableQuantityValidation;
use Modules\Cart\app\Rules\CartableTypeValidation;

class StoreCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cartable_id' => ['required', new CartableIdValidation],
            'cartable_type' => ['required' , new CartableTypeValidation],
            'quantity' => ["required","integer" , "min:1" , new CartableQuantityValidation],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
