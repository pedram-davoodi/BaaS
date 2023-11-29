<?php

namespace App\Events;

use App\ModelInterfaces\BlockedAccountModelInterface;
use App\ModelInterfaces\UserModelInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAccountBlocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public UserModelInterface $user, public BlockedAccountModelInterface $blockedAccount)
    {
    }
}
