<?php

namespace Modules\Order\app\Rules;

use App\Repositories\Base\OrderableInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderableTypeValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $interface = "App\Repositories\\".ucfirst($value)."RepositoryInterface";
         if (!interface_exists($interface) || !in_array(OrderableInterface::class, class_implements($interface))){
             $fail("The $value cannot be ordered.");
         }
    }
}
