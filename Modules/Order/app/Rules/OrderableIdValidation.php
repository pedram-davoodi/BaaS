<?php

namespace Modules\Order\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Auth;
use Throwable;

class OrderableIdValidation implements ValidationRule,DataAwareRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $repository = "App\Repositories\\".ucfirst($this->data['orderable_type'][array_search($value , $this->data['orderable_id'])])."RepositoryInterface";
            if (!app($repository)->getOneById($value)?->exists()) {
                $fail("product dose not exits");
            }
        }catch (Throwable $throwable){
            $fail($throwable->getMessage());
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
