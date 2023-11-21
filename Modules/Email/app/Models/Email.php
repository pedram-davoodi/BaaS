<?php

namespace Modules\Email\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\DataObjects\Email as EmailDataObject;

class Email extends EmailDataObject
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

}
