<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Attendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");

        $nowDate = Carbon::now()->format('Y-m-d');
        $attendances = DB::connection('park-royale')
            ->table('tb_work_timeline')
            ->get();
        foreach ($attendances as $schedule) {
            \Log::info($nowDate);
            \Log::info($schedule->date);
            $status = $nowDate > $schedule->date;
            if ($status) {
                \Log::info('late');
            }
        }
    }
}
