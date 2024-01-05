<?php

namespace App\Jobs;

use App\Mail\MonthlyUtilityMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBulkUtilityMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $ar, $db_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $ar, $db_name)
    {
        $this->email = $email;
        $this->ar = $ar;
        $this->db_name = $db_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new MonthlyUtilityMail($this->ar, $this->db_name));
    }
}
