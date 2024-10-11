<?php

namespace Modules\Cart\app\Models;

use App\ModelInterfaces\CartModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model implements CartModelInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["items" , "user_id"];

    protected static function newFactory(): CartFactory
    {
        //return CartFactory::new();
    }
}
