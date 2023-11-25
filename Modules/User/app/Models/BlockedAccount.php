<?php

namespace Modules\User\app\Models;

use App\ModelInterfaces\BlockedAccountModelInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockedAccount extends Model implements BlockedAccountModelInterface
{

    protected $casts = [
        'expired_at' => 'datetime:Y-m-d H:i:s'
    ];
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
}
