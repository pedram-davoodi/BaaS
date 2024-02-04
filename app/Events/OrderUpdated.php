<?php

namespace App\Events;

use App\ModelInterfaces\OrderItemModelInterface;
use App\ModelInterfaces\OrderModelInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class OrderUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public OrderModelInterface $order)
    {
    }
}
