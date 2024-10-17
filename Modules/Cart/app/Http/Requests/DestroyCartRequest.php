<?php

namespace Modules\Cart\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Cart\app\Rules\CartableExistsValidation;
use Modules\Cart\app\Rules\CartableIdValidation;
use Modules\Cart\app\Rules\CartableQuantityValidation;
use Modules\Cart\app\Rules\CartableTypeValidation;

class DestroyCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cartable_id' => ['required', new CartableIdValidation],
            'cartable_type' => ['required' , new CartableTypeValidation , new CartableExistsValidation],
            'quantity' => ["nullable","integer" , "min:1"],
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
