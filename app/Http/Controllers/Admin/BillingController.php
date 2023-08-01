<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CashReceiptDetail;
use App\Models\ElectricUUS;
use App\Models\IPLType;
use App\Models\MonthlyArTenant;
use App\Models\MonthlyIPL;
use App\Models\MonthlyUtility;
use App\Models\ReminderLetter;
use App\Models\System;
use App\Models\Unit;
use App\Models\Utility;
use App\Models\WaterUUS;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Dflydev\DotAccessData\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;

class BillingController extends Controller
{
    public function generateMonthlyInvoice(Request $request)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());
        $connWaterUUS = ConnectionDB::setConnection(new WaterUUS());

        $elecUSS = $connElecUUS->where('periode_bulan', $request->periode_bulan)
            ->where('periode_tahun', $request->periode_tahun)
            ->first();

        $waterUSS = $connWaterUUS->where('periode_bulan', $request->periode_bulan)
            ->where('periode_tahun', $request->periode_tahun)
            ->first();

        try {
            DB::beginTransaction();

            $createIPLbill = $this->createIPLbill($elecUSS, $request);
            $createUtilityBill = $this->createUtilityBill($elecUSS, $waterUSS, $createIPLbill);
            $createMonthlyTenant = $this->createMonthlyTenant($createUtilityBill, $createIPLbill);
            $transaction = $this->createTransaction($createMonthlyTenant);

            $createMonthlyTenant->no_monthly_invoice = $transaction->no_invoice;
            $createMonthlyTenant->save();
            $createIPLbill->no_monthly_invoice = $transaction->no_invoice;
            $createIPLbill->save();
            $createUtilityBill->no_monthly_invoice = $transaction->no_invoice;
            $createUtilityBill->save();
            $transaction->save();

            $elecUSS->no_refrensi = $transaction->no_invoice;
            $elecUSS->save();
            $waterUSS->no_refrensi = $transaction->no_invoice;
            $waterUSS->save();

            HelpNotifikasi::paymentMonthlyTenant($elecUSS, $transaction);

            Alert::success('Berhasil', 'Berhasil generate invoice');

            return redirect()->back();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', $e);
            return redirect()->back();
        }
    }

    public function createMonthlyTenant($createUtilityBill, $createIPLbill)
    {
        dd($createUtilityBill, $createIPLbill);
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $connReminder = ConnectionDB::setConnection(new ReminderLetter());

        $jatuh_tempo_1 = $connReminder->find(1)->durasi_reminder_letter;
        $jatuh_tempo_1 = Carbon::now()->addDays($jatuh_tempo_1);

        $connMonthlyTenant->id_site = $createUtilityBill->id_site;
        $connMonthlyTenant->id_tower = $createUtilityBill->id_tower;
        $connMonthlyTenant->id_unit = $createUtilityBill->id_unit;
        $connMonthlyTenant->id_tenant = $createUtilityBill->id_tenant;
        $connMonthlyTenant->periode_bulan = $createUtilityBill->periode_bulan;
        $connMonthlyTenant->periode_tahun = $createUtilityBill->periode_tahun;
        $connMonthlyTenant->total_tagihan_ipl = $createIPLbill->total_tagihan_ipl;
        $connMonthlyTenant->total_tagihan_utility = $createUtilityBill->total_tagihan_utility;
        $connMonthlyTenant->tgl_jt_invoice = $jatuh_tempo_1;


        return $connMonthlyTenant;
    }

    public function createIPLbill($elecUSS, $request)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connIPL = ConnectionDB::setConnection(new MonthlyIPL());
        $connIPLType = ConnectionDB::setConnection(new IPLType());

        $sc = $connIPLType->find(6);
        $sf = $connIPLType->find(7);
        $unit = $connUnit->find($elecUSS->id_unit);

        $ipl_service_charge = (int) $unit->luas_unit * $sc->biaya_permeter;
        $ipl_sink_fund = $ipl_service_charge * ($sf->biaya_procentage / 100);

        $total_tagihan_ipl = $ipl_service_charge + $ipl_sink_fund;

        $connIPL->id_site = $unit->id_site;
        $connIPL->id_tower = $unit->id_tower;
        $connIPL->id_unit = $unit->id_unit;
        $connIPL->id_tenant = $unit->TenantUnit->id_tenant;
        $connIPL->periode_bulan = $request->periode_bulan;
        $connIPL->periode_tahun = $request->periode_tahun;
        $connIPL->ipl_service_charge = $ipl_service_charge;
        $connIPL->ipl_sink_fund = $ipl_sink_fund;
        $connIPL->total_tagihan_ipl = $total_tagihan_ipl;

        return $connIPL;
    }

    public function createUtilityBill($elecUSS, $waterUSS, $createIPLbill)
    {
        $connMonthlyUtility = ConnectionDB::setConnection(new MonthlyUtility());
        $connUtility = ConnectionDB::setConnection(new Utility());

        $listrik = $connUtility->find(1);
        $air = $connUtility->find(2);

        $water_bill = $waterUSS->usage == 0 ?
            $air->biaya_abodemen : $waterUSS->usage * $air->biaya_tetap + ($air->biaya_admin + $air->biaya_m3 + $air->biaya_pju + $air->biaya_ppj);
        $elec_bill = $elecUSS->usage == 0 ?
            $listrik->biaya_abodemen : $elecUSS->usage * $listrik->biaya_tetap + ($listrik->biaya_admin + $listrik->biaya_m3 + $listrik->biaya_pju + $listrik->biaya_ppj);

        $total_tagihan = $water_bill + $elec_bill;

        $connMonthlyUtility->id_site = $createIPLbill->id_site;
        $connMonthlyUtility->id_tower = $createIPLbill->id_tower;
        $connMonthlyUtility->id_unit = $createIPLbill->id_unit;
        $connMonthlyUtility->id_tenant = $createIPLbill->id_tenant;
        $connMonthlyUtility->periode_bulan = $createIPLbill->periode_bulan;
        $connMonthlyUtility->periode_tahun = $createIPLbill->periode_tahun;
        $connMonthlyUtility->meter_air = $waterUSS->usage;
        $connMonthlyUtility->meter_listrik = $elecUSS->usage;
        $connMonthlyUtility->total_tagihan_utility = $total_tagihan;

        return $connMonthlyUtility;
    }

    public function createTransaction($createMonthlyTenant)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $system = $connSystem->find(1);

        $user = $createMonthlyTenant->Unit->TenantUnit->Tenant->User;

        $countCR = $system->sequence_no_cash_receiptment + 1;
        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countCR);
        $countINV = $system->sequence_no_invoice + 1;
        $no_inv = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countINV);

        $order_id = $user->id_site . '-' . $no_cr;

        $admin_fee = 5000;

        try {
            DB::beginTransaction();

            $subtotal = $createMonthlyTenant->total_tagihan_utility + $createMonthlyTenant->total_tagihan_ipl;

            $items = [];

            $ipl = new stdClass();
            $ipl->id = 1;
            $ipl->quantity = 1;
            $ipl->detil_pekerjaan = 'Pembayaran tagihan IPL bulan ' . $createMonthlyTenant->periode_bulan;
            $ipl->detil_biaya_alat = $createMonthlyTenant->total_tagihan_ipl;
            array_push($items, $ipl);

            $sc = new stdClass();
            $sc->id = 2;
            $sc->quantity = 1;
            $sc->detil_pekerjaan = 'Pembayaran tagihan Service Charge bulan ' . $createMonthlyTenant->periode_bulan;
            $sc->detil_biaya_alat = $createMonthlyTenant->total_tagihan_utility;
            array_push($items, $sc);

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $no_inv;
            $createTransaction->no_invoice = $no_inv;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'INV/' . $user->id_user . '/' . $createMonthlyTenant->Unit->nama_unit;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $subtotal;
            $createTransaction->gross_amount = $subtotal + $admin_fee;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $user->id_user;
            $createTransaction->transaction_type = 'MonthlyTenant';

            // $midtrans = new CreateSnapTokenService($createTransaction, $items);

            // $createTransaction->snap_token = $midtrans->getSnapToken();
            // $createTransaction->save();

            $connCRd = ConnectionDB::setConnection(new CashReceiptDetail());
            $connCRd->create([
                'no_draft_cr' => $no_cr,
                'ket_transaksi' => 'Pembayaran bulan IPL dan Utility' . $createMonthlyTenant->periode_bulan,
                'tx_amount' => $subtotal + $admin_fee
            ]);

            $system->sequence_no_cash_receiptment = $countCR;
            $system->sequence_no_invoice = $countINV;
            $system->save();


            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back();
        }

        return $createTransaction;
    }
}
