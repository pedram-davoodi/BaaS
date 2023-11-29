<?php

namespace Modules\Email\app\Listeners;

use App\Events\ForgetPassword;
use Modules\Email\app\Jobs\SendEmail;
use Modules\Email\app\Models\Email;

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
        $email = Email::create([
            'subject' => 'Forget Password',
            'to' => $event->user->email,
            'status' => 'Pending',
            'body' => "Your token is : {$event->token}",
        ]);
        SendEmail::dispatch($email)->onQueue('highPriority');
    }
}
