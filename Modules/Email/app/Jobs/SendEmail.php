<?php

namespace Modules\Email\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Email\app\Models\Email;

class SendEmail implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Email $email)
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
