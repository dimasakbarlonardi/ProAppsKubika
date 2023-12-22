<?php

namespace App\Jobs;

use App\Mail\MyTestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailList = $this->data['emails'];

        $details = [
            'title' => 'This is for testing email using smtp',
            'body' => 'TMail from akmal rifqi from proapps email :)',
        ];

        foreach ($emailList as $email) {
            Mail::to($email['email'])->send(new MyTestMail($details));
            Log::info('sending to ' . $email['email']);
        }
    }
}
