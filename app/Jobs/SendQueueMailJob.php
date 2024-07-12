<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendQueueMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $maildata;
    public $timeout = 7200;
    /**
     * Create a new job instance.
     */
    public function __construct($maildata)
    {
        $this->maildata = $maildata;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->maildata as $value) {
            try {
                Mail::to($value['email'])->send(new SendMail($value));
            } catch (\Throwable $th) {
                $this->failed($th);
            }
        }
    }

    public function failed(\Throwable $throwable)
    {
        return back()->with('error', $throwable->getMessage());
    }
}
