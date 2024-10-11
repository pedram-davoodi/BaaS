<?php

namespace Modules\Order\app\Repository\Eloquent;

use App\Repositories\Base\EloquentRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductCategoryRepositoryInterface;

class OrderRepository extends EloquentRepository implements OrderRepositoryInterface
{}
