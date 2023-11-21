<?php

namespace App\Console\Commands;

use App\Events\HelloEvent;
use App\Models\ReminderLetter;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SP1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:sp1';

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
        $sp1 = DB::connection('park-royale')
            ->table('tb_reminder_letter')
            ->where('id_reminder_letter', 2)
            ->first();

        $monthlyData = DB::connection('park-royale')
            ->table('tb_fin_monthly_ar_tenant as m')
            ->where('m.tgl_jt_invoice', '<', Carbon::now())
            ->whereNull('m.sp1')
            ->select(
                'm.sp1',
                'm.tgl_jt_invoice',
                'm.no_monthly_invoice',
                'cr.id_user',
                'm.id_monthly_ar_tenant',
                'm.id_unit'
            )
            ->join('tb_draft_cash_receipt as cr', 'cr.no_invoice', 'm.no_monthly_invoice')
            ->get();

        foreach ($monthlyData as $data) {
            dd($monthlyData);
            $jt = Carbon::createFromFormat('Y-m-d', $data->tgl_jt_invoice);
            $sp1Date = $jt->addDays($sp1->durasi_reminder_letter);
            if ($sp1Date < Carbon::now() && !$data->sp1) {
                $monthlyData = DB::connection('park-royale')
                    ->table('tb_fin_monthly_ar_tenant')
                    ->where('id_monthly_ar_tenant', $data->id_monthly_ar_tenant)
                    ->update([
                        'sp1' => true
                    ]);
            }

            $dataNotif = [
                'models' => 'MonthlyTenant',
                'notif_title' => $data->no_monthly_invoice,
                'id_data' => $data->id_monthly_ar_tenant,
                'sender' => null,
                'division_receiver' => null,
                'notif_message' => 'Surat Peringatan 1',
                'receiver' => $data->id_user,
                'connection' => 'park-royale'
            ];

            broadcast(new HelloEvent($dataNotif));
        }
    }
}
