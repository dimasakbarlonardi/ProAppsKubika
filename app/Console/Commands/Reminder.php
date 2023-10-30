<?php

namespace App\Console\Commands;

use App\Events\HelloEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:cron';

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
        $reminderPR = DB::connection('park-royale')
            ->table('tb_reminders')
            ->get();

        foreach ($reminderPR as $schedule) {
            $reminder_date = $schedule->reminder_date;
            $remind_before =  $schedule->remind_before;
            $nowDate = Carbon::now()->format('Y-m-d');
            $remind_on = date('Y-m-d', strtotime("-${remind_before} day", strtotime($reminder_date)));

            if ($nowDate == $remind_on) {
                $dataNotifWR = [
                    'models' => 'Reminder',
                    'notif_title' => HumanDate($schedule->reminder_date),
                    'id_data' => $schedule->id,
                    'sender' => null,
                    'division_receiver' => $schedule->work_relation_id,
                    'notif_message' => $schedule->reminder_name . ' berkahir pada ',
                    'receiver' => null,
                    'connection' => 'park-royale'
                ];

                broadcast(new HelloEvent($dataNotifWR));

                $dataNotifBM = [
                    'models' => 'Reminder',
                    'notif_title' => HumanDate($schedule->reminder_date),
                    'id_data' => $schedule->id,
                    'sender' => null,
                    'division_receiver' => 2,
                    'notif_message' => $schedule->reminder_name . ' berkahir pada ',
                    'receiver' => null,
                    'connection' => 'park-royale'
                ];

                broadcast(new HelloEvent($dataNotifBM));

                \Log::info('Remind on ' . $remind_on);
            }
        }
    }
}
