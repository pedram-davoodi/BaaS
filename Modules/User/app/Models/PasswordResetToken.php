<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $primaryKey = 'email';

    const UPDATED_AT = null;

    protected $fillable = [
        'email',
        'token',
    ];
}
