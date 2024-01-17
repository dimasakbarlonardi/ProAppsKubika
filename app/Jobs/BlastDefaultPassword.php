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
    protected $db_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($db_name)
    {
        $this->db_name = $db_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tenants = new Tenant();
        $tenants = $tenants->setConnection($this->db_name);
        $tenants = $tenants->get();
        foreach ($tenants as $tenant) {
            Mail::to('dimasakbar@mail.com')->send(new DefaultPassword($tenant));
        }
    }
}
