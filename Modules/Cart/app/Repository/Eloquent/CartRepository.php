<?php

namespace Modules\Cart\app\Repository\Eloquent;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\ProductCategoryRepositoryInterface;

class CartRepository extends EloquentRepository implements ProductCategoryRepositoryInterface
{}
