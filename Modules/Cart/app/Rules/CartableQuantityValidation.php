<?php

namespace Modules\Cart\app\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CartableQuantityValidation implements ValidationRule,DataAwareRule
{

    protected array $data = [];


    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $repository = "App\Repositories\\".ucfirst($this->data['cartable_type'])."RepositoryInterface";
        $item = app($repository)->getOneById($this->data['cartable_id']);

        if (!$item?->exists() || !$item->quantityAllowed($value)) {
            $fail("quantity limit exceeded");
        }
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
