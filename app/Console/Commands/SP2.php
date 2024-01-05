<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SP2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:sp2';

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
        $this->getSP2Data('park-royale');
    }

    function getSP2Data($table)
    {
        $sp2 = DB::connection($table)
            ->table('tb_reminder_letter')
            ->where('id_reminder_letter', 3)
            ->first();

        $monthlyData = DB::connection($table)
            ->table('tb_fin_monthly_ar_tenant as m')
            ->join('tb_draft_cash_receipt as cr', 'm.id_monthly_ar_tenant', 'cr.id_monthly_ar_tenant')
            ->where('cr.tgl_jt_invoice', '<', Carbon::now())
            ->where('m.sp1', '!=', null)
            ->whereNull('m.sp2')
            ->select(
                'm.sp2',
                'cr.tgl_jt_invoice',
                'm.no_monthly_invoice',
                'cr.id_user',
                'm.id_monthly_ar_tenant',
                'm.id_unit'
            )
            ->get();

        foreach ($monthlyData as $data) {
            $jt = Carbon::createFromFormat('Y-m-d', $data->tgl_jt_invoice);
            $sp1Date = $jt->addDays($sp2->durasi_reminder_letter);
            if ($sp1Date < Carbon::now() && !$data->sp2) {
                $monthlyData = DB::connection($table)
                    ->table('tb_fin_monthly_ar_tenant')
                    ->where('id_monthly_ar_tenant', $data->id_monthly_ar_tenant)
                    ->update([
                        'sp2' => true
                    ]);
            }
        }
    }
}
