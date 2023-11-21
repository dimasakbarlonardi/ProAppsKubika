<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Attendance
        $schedule->command('attendance:cron')->daily();
        // $schedule->command('attendance:cron')->everyMinute(); //dev

        // Reminder
        $schedule->command('reminder:cron')->daily();
        // $schedule->command('reminder:cron')->everyMinute();

        // SP1
        $schedule->command('monthly:sp1')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
