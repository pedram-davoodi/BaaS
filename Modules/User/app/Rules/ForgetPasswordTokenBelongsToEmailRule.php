<?php

namespace Modules\User\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;
use App\Repositories\PasswordResetTokenRepositoryInterface;

class ForgetPasswordTokenBelongsToEmailRule implements ValidationRule, ValidatorAwareRule
{
    public function __construct(protected ?string $email)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tokenExists = app(PasswordResetTokenRepositoryInterface::class)->getFirstWhere([
            'email' => $this->email ,
            'token' => $value
        ])?->exists() ?? null;

        if (! $tokenExists) {
            $fail(__('user.restPassword.invalidToken'));
        }
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }
}
