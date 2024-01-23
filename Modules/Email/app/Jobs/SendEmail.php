<?php

namespace Modules\Email\app\Jobs;

use App\ModelInterfaces\EmailModelInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public EmailModelInterface $email)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->email->update([
            'status' => 'Sending',
        ]);
    }
}
