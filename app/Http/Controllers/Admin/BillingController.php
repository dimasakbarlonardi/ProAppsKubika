<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Helpers\InvoiceHelper;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CashReceiptDetail;
use App\Models\CompanySetting;
use App\Models\ElectricUUS;
use App\Models\Installment;
use App\Models\IPLType;
use App\Models\JenisDenda;
use App\Models\MonthlyArTenant;
use App\Models\MonthlyIPL;
use App\Models\MonthlyUtility;
use App\Models\Notifikasi;
use App\Models\PerhitDenda;
use App\Models\ReminderLetter;
use App\Models\Site;
use App\Models\System;
use App\Models\Unit;
use App\Models\Utility;
use App\Models\WaterUUS;
use App\Models\WorkOrder;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use DateTime;
use Dflydev\DotAccessData\Util;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\CoreApi;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Throwable;

class BillingController extends Controller
{
    function validateUtility($request, $id)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());
        $connWaterUUS = ConnectionDB::setConnection(new WaterUUS());
        $status = false;

        if ($request->type == 'electric') {
            $data['elecUSS'] = $connElecUUS->find($id);
            $data['waterUSS'] = $connWaterUUS->where('periode_bulan', $data['elecUSS']->periode_bulan)
                ->where('is_approve', '1')
                ->where('periode_tahun', $data['elecUSS']->periode_tahun)
                ->where('id_unit', $data['elecUSS']->id_unit)
                ->first();
            $status = $data['elecUSS']->Unit->TenantUnit->Tenant->User ? true : false;
            $nama_unit = $data['elecUSS']->Unit->nama_unit;
        } elseif ($request->type == 'water') {
            $data['waterUSS'] = $connWaterUUS->find($id);
            $data['elecUSS'] = $connElecUUS->where('periode_bulan', $data['waterUSS']->periode_bulan)
                ->where('is_approve', '1')
                ->where('periode_tahun', $data['waterUSS']->periode_tahun)
                ->where('id_unit', $data['waterUSS']->id_unit)
                ->first();
            $status = $data['waterUSS']->Unit->TenantUnit->Tenant->User ? true : false;
            $nama_unit = $data['elecUSS']->Unit->nama_unit;
        }

        if (!$status) {
            return response()->json([
                'status' => 401,
                'unit' => $nama_unit
            ]);
        }

        return $data;
    }

    public function generateMonthlyInvoice(Request $request)
    {
        foreach ($request->IDs as $id) {
            $validate = $this->validateUtility($request, $id);

            if ($validate['waterUSS'] && $validate['elecUSS'] && !$validate['waterUSS']->MonthlyUtility) {
                try {
                    DB::beginTransaction();

                    $this->createMonthlyARData($validate);

                    DB::commit();
                } catch (Throwable $e) {
                    DB::rollBack();
                    dd($e);
                    return response()->json(['status' => 'failed']);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    function createMonthlyARData($validate)
    {
        $connCompany = ConnectionDB::setConnection(new CompanySetting());

        $setting = $connCompany->find(1);

        try {
            DB::beginTransaction();
            $createIPLbill = $this->createIPLbill($validate['elecUSS']);
            $createUtilityBill = $this->createUtilityBill($validate['elecUSS'], $validate['waterUSS'], $createIPLbill);
            $createMonthlyTenant = $this->createMonthlyTenant($createUtilityBill, $createIPLbill, $validate['elecUSS'], $validate['waterUSS']);

            // $createIPLbill->save();
            // $createUtilityBill->save();

            $validate['elecUSS']->no_refrensi = $createUtilityBill->id;
            $validate['elecUSS']->save();
            $validate['waterUSS']->no_refrensi = $createUtilityBill->id;
            $validate['waterUSS']->save();

            $createMonthlyTenant->id_monthly_utility = $createUtilityBill->id;
            $createMonthlyTenant->id_monthly_ipl = $createIPLbill->id;
            // $createMonthlyTenant->save();

            if ($setting->is_split_ar == 0) {
                $no_inv = $this->generateInvoice($createMonthlyTenant, null, $setting);
                $createMonthlyTenant->no_monthly_invoice = $no_inv;
                // $createMonthlyTenant->save();
            } elseif ($setting->is_split_ar == 1) {
                for ($i = 0; $i < 2; $i++) {
                    $no_inv = $this->generateInvoice($createMonthlyTenant, $i, $setting);
                }
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);

            return redirect()->back();
        }
    }

    function generateInvoice($createMonthlyTenant, $i, $setting)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $invoiceData = InvoiceHelper::generateInvoiceNumber();

        if ($i == 0) {
            $transaction = $this->createTransaction($createMonthlyTenant, $setting, $i);
            $transaction->id_monthly_utility = $createMonthlyTenant->id_monthly_utility;
            $transaction->transaction_type = 'MonthlyUtilityTenant';
        } elseif ($i == 1) {
            $transaction = $this->createTransaction($createMonthlyTenant, $setting, $i);
            $transaction->id_monthly_ipl = $createMonthlyTenant->id_monthly_ipl;
            $transaction->transaction_type = 'MonthlyIPLTenant';
        } elseif (!$i) {
            $transaction = $this->createTransaction($createMonthlyTenant, $setting, null);
            $transaction->transaction_type = 'MonthlyTenant';
        }

        $previousBills = $connCR->where('transaction_type', $transaction->transaction_type)
            ->where('transaction_status', '!=', 'PAID')
            ->where('id_unit', $transaction->id_unit)
            ->get();

        $transaction = $this->perhitDenda($transaction, $previousBills);
        $transaction->no_reff = $invoiceData['no_inv'];
        $transaction->no_invoice = $invoiceData['no_inv'];
        $transaction->save();

        $invoiceData['system']->sequence_no_invoice = $invoiceData['countINV'];
        $invoiceData['system']->save();

        return $invoiceData['no_inv'];
    }

    // save
    public function createMonthlyTenant($createUtilityBill, $createIPLbill)
    {
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        // $connCR = ConnectionDB::setConnection(new CashReceipt());
        // $connCompany = ConnectionDB::setConnection(new CompanySetting());

        // $previousBills = $connCR->where('tgl_jt_invoice', '<', Carbon::now()->format('Y-m-d'))
        //     ->where('id_unit', $createUtilityBill->id_unit)
        //     ->where('transaction_type', 'MonthlyTenant')
        //     ->where('transaction_status', '!=', 'PAID')
        //     ->get();

        // $setting = $connCompany->find(1);

        // if ($setting->is_split_ar == 0) {
        //     $connMonthlyTenant = $this->perhitDenda($connMonthlyTenant, $previousBills);
        // }

        $connMonthlyTenant->id_site = $createUtilityBill->id_site;
        $connMonthlyTenant->id_tower = $createUtilityBill->id_tower;
        $connMonthlyTenant->id_unit = $createUtilityBill->id_unit;
        $connMonthlyTenant->id_tenant = $createUtilityBill->id_tenant;
        $connMonthlyTenant->periode_bulan = $createUtilityBill->periode_bulan;
        $connMonthlyTenant->periode_tahun = $createUtilityBill->periode_tahun;
        $connMonthlyTenant->total_tagihan_ipl = $createIPLbill->total_tagihan_ipl;
        $connMonthlyTenant->total_tagihan_utility = $createUtilityBill->total_tagihan_utility;
        // $connMonthlyTenant->total = $createIPLbill->total_tagihan_ipl + $createUtilityBill->total_tagihan_utility + $connMonthlyTenant->denda_bulan_sebelumnya;
        $connMonthlyTenant->total = $createIPLbill->total_tagihan_ipl + $createUtilityBill->total_tagihan_utility;

        return $connMonthlyTenant;
    }

    function perhitDenda($transaction, $previousBills)
    {
        $connDenda = ConnectionDB::setConnection(new JenisDenda());

        $perhitDenda = $connDenda->where('is_active', 1)->first();

        if ($perhitDenda->id_jenis_denda == 3) {
            $transaction = $this->dendaRolling($perhitDenda, $transaction, $previousBills);
        } elseif ($perhitDenda->id_jenis_denda == 2) {
            $transaction = $this->dendaTetap($perhitDenda, $transaction, $previousBills);
        } elseif ($perhitDenda->id_jenis_denda == 1) {
            $transaction = $this->dendaAkumulasi($perhitDenda, $transaction, $previousBills);
        }

        return $transaction;
    }

    // save
    function dendaRolling($perhitDenda, $transaction, $previousBills)
    {
        $total_denda = 0;

        foreach ($previousBills as $prevBill) {
            $jt = new DateTime($prevBill->tgl_jt_invoice);
            $now = Carbon::now();

            if ($perhitDenda->unity == 'day') {
                $jml_hari_jt = $now->diff($jt)->format("%a");
            } elseif ($perhitDenda->unity == 'month') {
                $jml_hari_jt = $now->diff($jt)->format("%m");
            }

            if ($perhitDenda->denda_flat_procetage != 0) {
                $denda_bulan_sebelumnya = ((($perhitDenda->denda_flat_procetage / 100) * ($prevBill->total_tagihan_ipl + $prevBill->total_tagihan_utility)) * $jml_hari_jt);
            } else {
                $denda_bulan_sebelumnya = $jml_hari_jt * $perhitDenda->denda_flat_amount;
            }

            $prevBill->jml_hari_jt = $jml_hari_jt;
            $prevBill->total_denda = $denda_bulan_sebelumnya;
            $prevBill->save();

            $total_denda += $prevBill->total_denda;

            $transaction->denda_bulan_sebelumnya = $total_denda;
        }

        return $transaction;
    }

    // save
    function dendaTetap($perhitDenda, $transaction, $previousBills)
    {
        foreach ($previousBills as $prevBill) {
            $prevMonthDays =  Carbon::createFromFormat('Y-m', $prevBill->periode_tahun . '-' . $prevBill->periode_bulan)->format('Y-m');
            $prevMonthDays = Carbon::parse($prevMonthDays)->daysInMonth;

            if ($perhitDenda->denda_flat_procetage != 0) {
                $denda_bulan_sebelumnya = (($perhitDenda->denda_flat_procetage / 100) * ($prevBill->total_tagihan_ipl + $prevBill->total_tagihan_utility) * $prevMonthDays);
            } else {
                $denda_bulan_sebelumnya = $prevMonthDays * $perhitDenda->denda_flat_amount;
            }

            $prevBill->total_denda = $denda_bulan_sebelumnya;
            $prevBill->jml_hari_jt = $prevMonthDays;
            $prevBill->save();

            $transaction->denda_bulan_sebelumnya = $denda_bulan_sebelumnya;
        }

        return $transaction;
    }

    // save
    function dendaAkumulasi($perhitDenda, $transaction, $previousBills)
    {
        foreach ($previousBills as $prevBill) {
            $prevMonthDays =  Carbon::createFromFormat('Y-m', $prevBill->MonthlyARTenant->periode_tahun . '-' . $prevBill->MonthlyARTenant->periode_bulan)->format('Y-m');
            $prevMonthDays = Carbon::parse($prevMonthDays)->daysInMonth;

            if ($perhitDenda->denda_flat_procetage != 0) {
                $denda_bulan_sebelumnya = ((($perhitDenda->denda_flat_procetage / 100) * ($prevBill->MonthlyARTenant->total_tagihan_ipl + $prevBill->MonthlyARTenant->total_tagihan_utility)) * $prevMonthDays);
            } else {
                $denda_bulan_sebelumnya = $prevMonthDays * $perhitDenda->denda_flat_amount;
            }

            $prevBill->total_denda += $denda_bulan_sebelumnya;
            $prevBill->denda_bulan_sebelumnya += $prevBill->denda_bulan_sebelumnya;
            $prevBill->jml_hari_jt += $prevMonthDays;
            $prevBill->save();

            $transaction->denda_bulan_sebelumnya = $denda_bulan_sebelumnya + $prevBill->MonthlyARTenant->denda_bulan_sebelumnya;
        }

        return $transaction;
    }

    // save
    public function createIPLbill($elecUSS)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connIPL = ConnectionDB::setConnection(new MonthlyIPL());
        $connIPLType = ConnectionDB::setConnection(new IPLType());

        $unit = $connUnit->find($elecUSS->id_unit);

        if ($unit->id_hunian == 1) {
            $sc = $connIPLType->find(6);
            $sf = $connIPLType->find(7);
        } elseif ($unit->id_hunian == 2) {
            $sc = $connIPLType->find(8);
            $sf = $connIPLType->find(9);
        }

        $currMonthDays =  Carbon::now()->daysInMonth;
        $cutOFFsc = (int) Carbon::now()->diff($unit->Owner()->tgl_masuk)->format("%a");

        $ipl_service_charge = (int) $unit->luas_unit * $sc->biaya_permeter;
        $ipl_price_day = ((int) $unit->luas_unit * $sc->biaya_permeter) / $currMonthDays;

        if ($cutOFFsc < $currMonthDays) {
            $ipl_service_charge = $cutOFFsc * $ipl_price_day;
        }

        if ($sf->biaya_procentage != null) {
            $ipl_sink_fund = $sf->biaya_procentage / 100 * $ipl_service_charge;
        } else {
            $ipl_sink_fund = $sf->biaya_permeter * (int) $unit->luas_unit;
        }

        $total_tagihan_ipl = $ipl_service_charge + $ipl_sink_fund;

        $connIPL->id_site = $unit->id_site;
        $connIPL->id_unit = $unit->id_unit;
        $connIPL->periode_bulan = $elecUSS->periode_bulan;
        $connIPL->periode_tahun = $elecUSS->periode_tahun;
        $connIPL->ipl_service_charge = $ipl_service_charge;
        $connIPL->ipl_sink_fund = $ipl_sink_fund;
        $connIPL->total_tagihan_ipl = $total_tagihan_ipl;

        return $connIPL;
    }

    // save
    public function createUtilityBill($elecUSS, $waterUSS, $createIPLbill)
    {
        $connMonthlyUtility = ConnectionDB::setConnection(new MonthlyUtility());

        $water_bill = $waterUSS->total;
        $elec_bill = $elecUSS->total;

        $total_tagihan = $water_bill + $elec_bill;

        $connMonthlyUtility->id_site = $createIPLbill->id_site;
        $connMonthlyUtility->id_unit = $createIPLbill->id_unit;
        $connMonthlyUtility->id_eng_listrik = $elecUSS->id;
        $connMonthlyUtility->id_eng_air = $waterUSS->id;
        $connMonthlyUtility->periode_bulan = $createIPLbill->periode_bulan;
        $connMonthlyUtility->periode_tahun = $createIPLbill->periode_tahun;
        $connMonthlyUtility->total_tagihan_utility = $total_tagihan;

        return $connMonthlyUtility;
    }

    // save
    public function createTransaction($mt, $setting, $i)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $connInstallment = ConnectionDB::setConnection(new Installment());
        $system = $connSystem->find(1);

        $user = $mt->Unit->TenantUnit->Tenant->User;

        $countCR = $system->sequence_no_cash_receiptment + 1;
        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countCR);

        $order_id = $user->id_site . '-' . $no_cr;

        try {
            DB::beginTransaction();

            $subtotal = $mt->total_tagihan_utility + $mt->total_tagihan_ipl;
            // $subtotal = $mt->total_tagihan_utility + $mt->total_tagihan_ipl + $mt->total_denda;
            // $prevSubTotal = 0;
            // $total_denda = 0;

            // if ($mt->PreviousMonthBill()) {
            //     foreach ($mt->PreviousMonthBill() as $key => $prevBill) {
            //         $prevSubTotal += $prevBill->total_tagihan_utility + $prevBill->total_tagihan_ipl + $prevBill->total_denda;
            //         $total_denda += $prevBill->total_denda;

            //         $connCRd = ConnectionDB::setConnection(new CashReceiptDetail());
            //         $connCRd->create([
            //             'no_draft_cr' => $no_cr,
            //             'ket_transaksi' => 'Pembayaran bulan IPL dan Utility ' . $prevBill->periode_bulan,
            //             'tx_amount' => $prevSubTotal
            //         ]);
            //     }
            // }

            $amountInstallment = 0;
            $installment = $connInstallment->where('periode', $mt->periode_bulan)
                ->where('tahun', $mt->periode_tahun)
                ->first();

            if ($installment) {
                $amountInstallment = $installment->amount;
            }

            // if ($setting->is_split_ar == 0 && !$i) {
            //     $subtotal = $subtotal + $prevSubTotal + $amountInstallment;
            // } elseif ($setting->is_split_ar == 1 && $i == 0) {
            //     $subtotal = $mt->total_tagihan_utility + $amountInstallment;
            // } elseif ($setting->is_split_ar == 1 && $i == 1) {
            //     $subtotal = $mt->total_tagihan_ipl + $amountInstallment;
            // }
            if ($setting->is_split_ar == 0 && !$i) {
                $subtotal = $subtotal + $amountInstallment;
            } elseif ($setting->is_split_ar == 1 && $i == 0) {
                $subtotal = $mt->total_tagihan_utility + $amountInstallment;
            } elseif ($setting->is_split_ar == 1 && $i == 1) {
                $subtotal = $mt->total_tagihan_ipl + $amountInstallment;
            }

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $mt->no_monthly_invoice;
            $createTransaction->no_invoice = $mt->no_monthly_invoice;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'INV/' . $user->id_user . '/' . $mt->Unit->nama_unit;
            $createTransaction->sub_total = $subtotal;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $user->id_user;
            $createTransaction->id_unit = $mt->id_unit;
            $createTransaction->id_monthly_ar_tenant = $mt->id_monthly_ar_tenant;

            $system->sequence_no_cash_receiptment = $countCR;
            $system->save();

            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back();
        }

        return $createTransaction;
    }

    public function getOverdueARTenant(Request $request)
    {
        $connARTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $connCR = ConnectionDB::setConnection(new CashReceipt());

        $cr = $connCR->where('snap_token', $request->token)->first();

        $prevMonth = (int) $cr->MonthlyARTenant->periode_bulan - 1;
        $prevMonth = '0' . $prevMonth;

        $data = $connARTenant->where('periode_tahun', Carbon::now()->format('Y'))
            ->where('tgl_jt_invoice', '<', Carbon::now()->format('Y-m-d'))
            ->where('tgl_bayar_invoice', null)
            ->orderBy('periode_bulan', 'asc')
            ->get(['periode_bulan', 'periode_tahun', 'jml_hari_jt', 'total_denda']);

        return response()->json([
            $data
        ]);
    }

    //save
    public function blastMonthlyInvoice(Request $request)
    {
        $connReminder = ConnectionDB::setConnection(new ReminderLetter());
        $connElec = ConnectionDB::setConnection(new ElectricUUS());
        $connWater = ConnectionDB::setConnection(new WaterUUS());
        $connSetting = ConnectionDB::setConnection(new CompanySetting());

        $setting = $connSetting->find(1);

        foreach ($request->IDs as $id) {
            try {
                DB::beginTransaction();

                if ($request->type == 'electric') {
                    $util = $connElec->where('id', $id)
                        ->where('is_approve', '1')
                        ->first();
                } elseif ($request->type == 'water') {
                    $util = $connWater->where('id', $id)
                        ->where('is_approve', '1')
                        ->first();
                }

                $arTenant = $util->MonthlyUtility->MonthlyTenant->CashReceipts[0];

                if (!$arTenant->tgl_jt_invoice && !$arTenant->tgl_bayar_invoice) {
                    $jatuh_tempo_1 = $connReminder->find(1)->durasi_reminder_letter;
                    $jatuh_tempo_1 = Carbon::now()->addDays($jatuh_tempo_1);

                    if ($setting->is_split_ar == 0) {
                        $util->MonthlyUtility->MonthlyTenant->CashReceipt->tgl_jt_invoice = $jatuh_tempo_1;
                        $util->MonthlyUtility->MonthlyTenant->CashReceipt->save();
                    } elseif ($setting->is_split_ar == 1) {
                        foreach ($util->MonthlyUtility->MonthlyTenant->CashReceipts as $bill) {
                            $bill->tgl_jt_invoice = $jatuh_tempo_1;
                            $bill->save();
                        }
                    }

                    $util->MonthlyUtility->MonthlyTenant->MonthlyIPL->sign_approval_2 = Carbon::now();
                    $util->MonthlyUtility->MonthlyTenant->MonthlyIPL->save();

                    $util->MonthlyUtility->sign_approval_2 = Carbon::now();
                    $util->MonthlyUtility->save();

                    $dataNotif = [
                        'models' => $setting->is_split_ar == 0 ? 'MonthlyTenant' : 'SplitMonthlyTenant',
                        'notif_title' => 'Monthly Invoice',
                        'id_data' => $util->MonthlyUtility->MonthlyTenant->id_monthly_ar_tenant,
                        'sender' => $request->session()->get('user')->id_user,
                        'division_receiver' => null,
                        'notif_message' => 'Harap melakukan pembayaran tagihan bulanan anda',
                        'receiver' => $util->MonthlyUtility->Unit->TenantUnit->Tenant->User->id_user
                    ];

                    broadcast(new HelloEvent($dataNotif));
                }


                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e);
                return response()->json(['status' => 'failed']);
            }
        }
        return response()->json(['status' => 'ok']);
    }

    public function viewInvoice($id)
    {
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());


        $data['transaction'] = $connMonthlyTenant->find($id);

        return view('Tenant.Notification.Invoice.index', $data);
    }

    // public function generatePaymentMonthly(Request $request, $id)
    // {
    //     // $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
    //     $connSetting = ConnectionDB::setConnection(new CompanySetting());
    //     $connCR = ConnectionDB::setConnection(new CashReceipt());

    //     // $mt = $connMonthlyTenant->find($id);
    //     $site = Site::find(Auth::user()->id_site);
    //     $setting = $connSetting->find(1);
    //     $client = new Client();
    //     $billing = explode(',', $request->billing);
    //     $admin_fee = $request->admin_fee;
    //     $transaction = $connCR->find($id);

    //     if ($transaction->transaction_status == 'PENDING') {
    //         if ($billing[0] == 'bank_transfer') {
    //             $transaction->gross_amount = $transaction->sub_total + $admin_fee;
    //             $transaction->payment_type = 'bank_transfer';
    //             $transaction->bank = Str::upper($billing[1]);
    //             $payment = [];

    //             $payment['payment_type'] = $billing[0];
    //             $payment['transaction_details']['order_id'] = $transaction->order_id;
    //             $payment['transaction_details']['gross_amount'] = (int) $transaction->gross_amount;
    //             $payment['bank_transfer']['bank'] = $billing[1];

    //             $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
    //                 'body' => json_encode($payment),
    //                 'headers' => [
    //                     'accept' => 'application/json',
    //                     'authorization' => 'Basic ' . base64_encode($site->midtrans_server_key),
    //                     'content-type' => 'application/json',
    //                 ],
    //                 "custom_expiry" => [
    //                     "order_time" => Carbon::now(),
    //                     "expiry_duration" => 1,
    //                     "unit" => "day"
    //                 ]
    //             ]);
    //             $response = json_decode($response->getBody());

    //             if ($response->status_code == 201) {
    //                 $transaction->va_number = $response->va_numbers[0]->va_number;
    //                 $transaction->expiry_time = $response->expiry_time;
    //                 $transaction->no_invoice = $transaction->no_invoice;
    //                 $transaction->admin_fee = $admin_fee;
    //                 $transaction->transaction_status = 'VERIFYING';

    //                 $transaction->save();

    //                 if ($setting->is_split_ar == 0) {
    //                     return redirect()->route('paymentMonthly', [$transaction->id_monthly_ar_tenant, $transaction->id]);
    //                 } else {
    //                     return redirect()->route(
    //                         'paymentMonthly',
    //                         [$transaction->SplitMonthlyARTenant($transaction->id_monthly_utility, $transaction->id_monthly_ipl)->id_monthly_ar_tenant, $transaction->id]
    //                     );
    //                 }
    //             } else {
    //                 Alert::info('Sorry', 'Our server is busy');
    //                 return redirect()->back();
    //             }
    //         } elseif ($request->billing == 'credit_card') {
    //             $transaction->payment_type = 'credit_card';
    //             $transaction->admin_fee = $admin_fee;
    //             $transaction->gross_amount = round($transaction->sub_total + $admin_fee);

    //             $getTokenCC = $this->TransactionCC($request);
    //             $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction);

    //             if ($setting->is_split_ar == 0) {
    //                 $mt = $transaction->MonthlyARTenant();
    //                 $mt->no_monthly_invoice = $transaction->no_invoice;
    //                 $mt->save();
    //             }

    //             $transaction->save();

    //             return redirect($chargeCC->redirect_url);
    //         }
    //     } else {
    //         return redirect()->back();
    //     }
    // }

    // public function ChargeTransactionCC($token, $transaction)
    // {
    //     $login = Auth::user();
    //     $site = Site::find($login->id_site);
    //     $server_key = $site->midtrans_server_key;

    //     try {
    //         $credit_card = array(
    //             'token_id' => $token,
    //             'authentication' => true,
    //             'bank' => 'bni'
    //         );

    //         $transactionData = array(
    //             "payment_type" => "credit_card",
    //             "transaction_details" => [
    //                 "gross_amount" => $transaction->gross_amount,
    //                 "order_id" => $transaction->order_id
    //             ],
    //         );

    //         $transactionData["credit_card"] = $credit_card;
    //         $result = CoreApi::charge($transactionData, $server_key);

    //         return $result;
    //     } catch (Throwable $e) {
    //         dd($e);
    //     }
    // }

    // public function TransactionCC($request)
    // {
    //     $expDate = explode('/', $request->expDate);
    //     $card_exp_month = $expDate[0];
    //     $card_exp_year = $expDate[1];

    //     $login = Auth::user();
    //     $site = Site::find($login->id_site);

    //     try {
    //         $token = CoreApi::cardToken(
    //             $request->card_number,
    //             $card_exp_month,
    //             $card_exp_year,
    //             $request->card_cvv,
    //             $site->midtrans_client_key
    //         );

    //         if ($token->status_code != 200) {
    //             return ResponseFormatter::error([
    //                 'message' => 'Unauthorized'
    //             ], 'Authentication Failed', 401);
    //         }

    //         return $token;
    //     } catch (\Throwable $e) {
    //         dd($e);
    //         return ResponseFormatter::error([
    //             'message' => 'Internar Error'
    //         ], 'Something went wrong', 500);
    //     }

    //     return response()->json(['token' => $token]);
    // }

    public function paymentMonthly($mt, $id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());

        $mt = $connMonthlyTenant->find($mt);
        $transaction = $connTransaction->find($id);

        $data['mt'] = $mt;
        $data['transaction'] = $transaction;

        return view('Tenant.Notification.Invoice.payment-monthly', $data);
    }

    public function generatePaymentWO(Request $request, $id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $transaction = $connCR->find($id);

        $client = new Client();
        $billing = explode(',', $request->billing);
        $admin_fee = $request->admin_fee;

        if ($transaction->transaction_status == 'PENDING') {
            if ($billing[0] == 'bank_transfer') {
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = $transaction->sub_total + $admin_fee;
                $transaction->payment_type = 'bank_transfer';
                $transaction->bank = Str::upper($billing[1]);

                $payment = [];

                $payment['payment_type'] = $billing[0];
                $payment['transaction_details']['order_id'] = $transaction->order_id;
                $payment['transaction_details']['gross_amount'] = $transaction->gross_amount;
                $payment['bank_transfer']['bank'] = $billing[1];

                $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
                    'body' => json_encode($payment),
                    'headers' => [
                        'accept' => 'application/json',
                        'authorization' => 'Basic U0ItTWlkLXNlcnZlci1VQkJEOVpMcUdRRFBPd2VpekdkSGFnTFo6',
                        'content-type' => 'application/json',
                    ],
                    "custom_expiry" => [
                        "order_time" => Carbon::now(),
                        "expiry_duration" => 1,
                        "unit" => "day"
                    ]
                ]);

                $response = json_decode($response->getBody());

                if ($response->status_code == 201) {
                    $transaction->va_number = $response->va_numbers[0]->va_number;
                    $transaction->expiry_time = $response->expiry_time;
                    $transaction->transaction_id = $response->transaction_id;
                    $transaction->transaction_status = 'VERIFYING';
                    $transaction->save();

                    return redirect()->route('paymentWO', [$transaction->WorkOrder->id, $transaction->id]);
                } else {
                    Alert::info('Sorry', 'Our server is busy');
                    return redirect()->back();
                }
            } elseif ($request->billing == 'credit_card') {
                $transaction->payment_type = 'credit_card';
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = round($transaction->sub_total + $admin_fee);

                $getTokenCC = $this->TransactionCC($request);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction);

                $transaction->no_monthly_invoice = $transaction->no_invoice;
                $transaction->save();

                return redirect($chargeCC->redirect_url);
            }
        } else {
            return redirect()->back();
        }
    }

    public function paymentWO($woID, $id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $connMonthlyTenant = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connMonthlyTenant->find($woID);
        $transaction = $connTransaction->find($id);

        $data['wo'] = $wo;
        $data['transaction'] = $transaction;

        return view('Tenant.Notification.Invoice.payment-wo', $data);
    }
}
