<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SP3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:sp3';

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
        $this->getSP3Data('park-royale');
    }

    function getSP3Data($table)
    {
        $sp3 = DB::connection($table)
            ->table('tb_reminder_letter')
            ->where('id_reminder_letter', 4)
            ->first();

        $monthlyData = DB::connection($table)
            ->table('tb_fin_monthly_ar_tenant as m')
            ->join('tb_draft_cash_receipt as cr', 'm.id_monthly_ar_tenant', 'cr.id_monthly_ar_tenant')
            ->where('cr.tgl_jt_invoice', '<', Carbon::now())
            ->where('m.sp2', '!=', null)
            ->whereNull('m.sp3')
            ->select(
                'm.sp3',
                'cr.tgl_jt_invoice',
                'm.no_monthly_invoice',
                'cr.id_user',
                'm.id_monthly_ar_tenant',
                'm.id_unit'
            )
            ->get();

        foreach ($monthlyData as $data) {
            $jt = Carbon::createFromFormat('Y-m-d', $data->tgl_jt_invoice);
            $sp1Date = $jt->addDays($sp3->durasi_reminder_letter);
            if ($sp1Date < Carbon::now() && !$data->sp3) {
                $monthlyData = DB::connection($table)
                    ->table('tb_fin_monthly_ar_tenant')
                    ->where('id_monthly_ar_tenant', $data->id_monthly_ar_tenant)
                    ->update([
                        'sp3' => true
                    ]);
            }
        }
    }
}
