<?php

namespace Modules\Order\app\Rules;

use App\ModelInterfaces\Base\Orderable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderableTypeValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $interface = "App\ModelInterfaces\\".ucfirst($value)."ModelInterface";
         if (!interface_exists($interface) || !in_array(Orderable::class, class_implements($interface))){
             $fail("The $value cannot be ordered.");
         }
    }
}
