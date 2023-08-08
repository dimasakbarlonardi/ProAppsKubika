<?php

namespace App\Console\Commands;

use App\Models\MonthlyArTenant;
use App\Models\PerhitDenda;
use App\Models\Site;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use stdClass;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

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
        $perhitDenda = new PerhitDenda();
        $perhitDenda = $perhitDenda->setConnection('park-royale');
        $perhitDenda = $perhitDenda->find(3);
        $perhitDenda = $perhitDenda->denda_flat_procetage ? $perhitDenda->denda_flat_procetage : $perhitDenda->denda_flat_amount;

        $modelMonthlyTenant = new MonthlyArTenant();
        $connMonthlyTenant = $modelMonthlyTenant->setConnection('park-royale');
        $monthlyOverdueTenant = $connMonthlyTenant->where('tgl_bayar_invoice', null)
            ->where('tgl_jt_invoice', '<', Carbon::now()->format('Y-m-d'))
            ->get();

        $monthlyTenant = $connMonthlyTenant->where('tgl_bayar_invoice', null);

        foreach ($monthlyOverdueTenant as $bill) {
            $nextMonth = (int) $bill->periode_bulan + 1;
            $nextMonth = '0' . $nextMonth;

            $nextBill = $connMonthlyTenant->where('periode_bulan', $nextMonth)
                ->where('periode_tahun', Carbon::now()->format('Y'))
                ->first();

            $prevBills = $connMonthlyTenant->where('periode_bulan', '<', $bill->periode_bulan)
                ->where('periode_tahun', Carbon::now()->format('Y'))
                ->get();

            $totalPrevBills = 0;

            if ($prevBills) {
                foreach($prevBills as $prevBill) {
                    $totalPrevBills += $prevBill->total_denda;
                }
            }

            $bill->jml_hari_jt += 1;
            $bill->total_denda += $perhitDenda;
            $bill->save();

            if ($nextBill) {
                $nextBill->denda_bulan_sebelumnya = $bill->total_denda;
                $nextBill->save();

                $total = $nextBill->denda_bulan_sebelumnya + $nextBill->total_tagihan_ipl + $nextBill->total_tagihan_utility + $totalPrevBills;

                $nextBill->CashReceipt->sub_total = $total;
                $nextBill->CashReceipt->gross_amount = $total + $nextBill->CashReceipt->admin_fee;
                $nextBill->CashReceipt->save();
            }
        }

        $totalTagihanIPL = 0;
        $totalTagihanUtility = 0;
        $totalDenda = 0;

        foreach($monthlyTenant->get() as $currBill) {
            $totalTagihanIPL += $currBill->total_tagihan_ipl;
            $totalTagihanUtility += $currBill->total_tagihan_utility;
            $totalDenda += $currBill->total_denda;

            $totalTagihan = $totalTagihanIPL + $totalTagihanUtility + $totalDenda;

        }
        $lastBill = $monthlyTenant->latest()->first();
        $lastBill->CashReceipt->sub_total = $totalTagihan;
        $lastBill->CashReceipt->gross_amount = $totalTagihan + $lastBill->CashReceipt->admin_fee;
        $lastBill->CashReceipt->save();
    }
}
