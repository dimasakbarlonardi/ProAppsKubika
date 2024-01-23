<?php

namespace App\Jobs;

use App\Mail\EmailKaryawan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BlastEmailKaryawan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $db_name, $karyawan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($db_name , $karyawan)
    {
        $this->db_name = $db_name;
        $this->karyawan = $karyawan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->karyawan->email_karyawan)->send(new EmailKaryawan($this->karyawan));
    }
}
