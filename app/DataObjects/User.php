<?php

namespace App\DataObjects;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $email
 */
abstract class User extends Authenticatable
{
}
