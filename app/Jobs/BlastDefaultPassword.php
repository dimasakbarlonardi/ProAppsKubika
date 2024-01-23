<?php

namespace App\Jobs;

use App\Mail\DefaultPassword;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BlastDefaultPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $db_name, $tenant;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($db_name, $tenant)
    {
        $this->db_name = $db_name;
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->tenant->email_tenant)->send(new DefaultPassword($this->tenant));
    }
}
