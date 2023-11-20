<?php

namespace Modules\User\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\app\Rules\ForgetPasswordTokenBelongsToEmailRule;

class RestPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email'],
            'token' => ['required','string','exists:password_reset_tokens,token',new ForgetPasswordTokenBelongsToEmailRule($this->email)],
            'password' => 'required',
            'c_password' => 'required|same:password',
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
