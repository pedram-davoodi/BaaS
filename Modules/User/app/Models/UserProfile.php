<?php

namespace Modules\User\app\Models;

use App\ModelInterfaces\UserProfileModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Database\Factories\UserProfileFactory;

class UserProfile extends Model implements UserProfileModelInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the user that owns the blocked account.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function newFactory(): UserProfileFactory
    {
        return UserProfileFactory::new();
    }
}
