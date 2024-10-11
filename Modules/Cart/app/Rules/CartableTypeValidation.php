<?php

namespace Modules\Cart\app\Rules;

use App\ModelInterfaces\Base\Cartable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CartableTypeValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $interface = "App\ModelInterfaces\\".ucfirst($value)."ModelInterface";
         if (!interface_exists($interface) || !in_array(Cartable::class, class_implements($interface))){
             $fail("The item cannot be added to the cart.");
         }
    }
}
