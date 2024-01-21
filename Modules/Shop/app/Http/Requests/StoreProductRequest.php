<?php

namespace Modules\Shop\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => 'required|string',
            'product_category_id' => 'nullable|exists:product_categories,id',
            "price" => 'required|integer|min:0',
            "image" => 'required|string',
            "description" => 'nullable|string',
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
