<?php

namespace App\ModelInterfaces;

use App\ModelInterfaces\Base\Cartable;
use App\ModelInterfaces\Base\Orderable;
use App\ModelInterfaces\Base\ModelInterface;

/**
 * @property string id
 * @property int price
 * @property string deleted_at
 */
interface ProductModelInterface extends ModelInterface,Cartable,Orderable
{
}
