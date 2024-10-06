<?php

namespace Modules\User\app\Models;

use App\ModelInterfaces\AdminModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\User\Database\Factories\AdminFactory;

class Admin extends Authenticatable implements AdminModelInterface
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }
}
