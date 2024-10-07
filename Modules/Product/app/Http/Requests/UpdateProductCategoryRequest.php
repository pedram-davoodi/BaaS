<?php

namespace Modules\Product\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:400'
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
