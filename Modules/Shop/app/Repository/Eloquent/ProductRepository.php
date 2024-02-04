<?php

namespace Modules\Shop\app\Repository\Eloquent;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository extends EloquentRepository implements ProductRepositoryInterface
{
    public function price(int $orderable_id): int
    {
        return $this->getOneByIdOrFail($orderable_id)->price;
    }
}
