<?php

namespace Modules\User\app\Models;

use App\ModelInterfaces\Base\ModelInterface;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model implements ModelInterface
{
    protected $primaryKey = 'email';

    const UPDATED_AT = null;

    protected $fillable = [
        'email',
        'token',
    ];
}
