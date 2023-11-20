<?php

namespace Modules\Email\app\Listeners;

use App\Events\ForgetPassword;

class NotifyUsersOfForgetPasswordToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ForgetPassword $event): void
    {
    }
}
