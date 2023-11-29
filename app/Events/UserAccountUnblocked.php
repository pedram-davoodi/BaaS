<?php

namespace App\Events;

use App\ModelInterfaces\UserModelInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAccountUnblocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public UserModelInterface $user)
    {
    }
}
