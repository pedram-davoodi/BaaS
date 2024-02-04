<?php

namespace Modules\Order\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Order\app\Rules\OrderableIdValidation;
use Modules\Order\app\Rules\OrderableTypeValidation;

class StoreOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "orderable_id" => "required|array",
            "orderable_type" => "required|array",
            "orderable_id.*" => ["required" , new OrderableIdValidation],
            "orderable_type.*" => ["required" , new OrderableTypeValidation],
            "physical_product" => "required|boolean",
            "shipping_address" => "nullable|string|max:2000",
            "shipping_method" => "nullable|string|max:200"
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
