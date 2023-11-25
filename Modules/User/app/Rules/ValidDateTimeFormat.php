<?php

namespace Modules\User\app\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDateTimeFormat implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return strtotime($value) && preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a valid date time in the format YYYY-MM-DD HH:MM:SS.';
    }
}
