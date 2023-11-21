<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CashReceiptDetail;
use App\Models\ElectricUUS;
use App\Models\Installment;
use App\Models\IPLType;
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
    public function generateMonthlyInvoice(Request $request)
    {
        $connElecUUS = ConnectionDB::setConnection(new ElectricUUS());
        $connWaterUUS = ConnectionDB::setConnection(new WaterUUS());
        $connSystem = ConnectionDB::setConnection(new System());
        $system = $connSystem->find(1);

        $countINV = $system->sequence_no_invoice + 1;

        $no_inv = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countINV);

        $status = false;
        foreach ($request->IDs as $id) {
            if ($request->type == 'electric') {
                $elecUSS = $connElecUUS->find($id);
                $waterUSS = $connWaterUUS->where('periode_bulan', $elecUSS->periode_bulan)
                    ->where('is_approve', '1')
                    ->where('periode_tahun', $elecUSS->periode_tahun)
                    ->where('id_unit', $elecUSS->id_unit)
                    ->first();
                $status = $elecUSS->Unit->TenantUnit->Tenant->User ? true : false;
                $nama_unit = $elecUSS->Unit->nama_unit;
            } elseif ($request->type == 'water') {
                $waterUSS = $connWaterUUS->find($id);
                $elecUSS = $connElecUUS->where('periode_bulan', $waterUSS->periode_bulan)
                    ->where('is_approve', '1')
                    ->where('periode_tahun', $waterUSS->periode_tahun)
                    ->where('id_unit', $waterUSS->id_unit)
                    ->first();
                $status = $waterUSS->Unit->TenantUnit->Tenant->User ? true : false;
                $nama_unit = $elecUSS->Unit->nama_unit;
            }

            if (!$status) {
                return response()->json([
                    'status' => 401,
                    'unit' => $nama_unit
                ]);
            }

            if ($waterUSS && $elecUSS && !$waterUSS->MonthlyUtility) {
                try {
                    DB::beginTransaction();

                    $createIPLbill = $this->createIPLbill($elecUSS);
                    $createUtilityBill = $this->createUtilityBill($elecUSS, $waterUSS, $createIPLbill);
                    $createMonthlyTenant = $this->createMonthlyTenant($createUtilityBill, $createIPLbill, $elecUSS, $waterUSS);

                    if ($createMonthlyTenant->Unit->TenantUnit) {
                        $createIPLbill->save();
                        $createUtilityBill->save();

                        $elecUSS->no_refrensi = $createUtilityBill->id;
                        $elecUSS->save();
                        $waterUSS->no_refrensi = $createUtilityBill->id;
                        $waterUSS->save();

                        $createMonthlyTenant->id_monthly_utility = $createUtilityBill->id;
                        $createMonthlyTenant->no_monthly_invoice = $no_inv;
                        $createMonthlyTenant->id_monthly_ipl = $createIPLbill->id;
                        $createMonthlyTenant->save();

                        $transaction = $this->createTransaction($createMonthlyTenant);
                        $transaction->no_reff = $no_inv;
                        $transaction->no_invoice = $no_inv;
                        $transaction->save();

                        $system->sequence_no_invoice = $countINV;
                        $system->save();

                        DB::commit();
                    }
                } catch (Throwable $e) {
                    DB::rollBack();
                    dd($e);
                    return response()->json(['status' => 'failed']);
                }
            }
        }
        return response()->json(['status' => 'ok']);
    }

    public function createMonthlyTenant($createUtilityBill, $createIPLbill)
    {
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $perhitDenda = ConnectionDB::setConnection(new PerhitDenda());

        $perhitDenda = $perhitDenda->find(3);
        $perhitDenda = $perhitDenda->denda_flat_procetage ? $perhitDenda->denda_flat_procetage : $perhitDenda->denda_flat_amount;

        $previousBills = $connMonthlyTenant->where('tgl_jt_invoice', '<', Carbon::now()->format('Y-m-d'))
            ->where('periode_tahun', Carbon::now()->format('Y'))
            ->where('id_unit', $createUtilityBill->id_unit)
            ->where('tgl_bayar_invoice', null)
            ->get();

        $total_denda = 0;

        foreach ($previousBills as $prevBill) {
            $jt = new DateTime($prevBill->tgl_jt_invoice);
            $now = Carbon::now();
            $jml_hari_jt = $now->diff($jt)->format("%a");

            $denda_bulan_sebelumnya = $jml_hari_jt * $perhitDenda;

            $prevBill->jml_hari_jt = $jml_hari_jt;
            $prevBill->total_denda = $denda_bulan_sebelumnya;
            $prevBill->save();

            $total_denda += $prevBill->total_denda;

            $connMonthlyTenant->denda_bulan_sebelumnya = $total_denda;
        }

        $connMonthlyTenant->id_site = $createUtilityBill->id_site;
        $connMonthlyTenant->id_tower = $createUtilityBill->id_tower;
        $connMonthlyTenant->id_unit = $createUtilityBill->id_unit;
        $connMonthlyTenant->id_tenant = $createUtilityBill->id_tenant;
        $connMonthlyTenant->periode_bulan = $createUtilityBill->periode_bulan;
        $connMonthlyTenant->periode_tahun = $createUtilityBill->periode_tahun;
        $connMonthlyTenant->total_tagihan_ipl = $createIPLbill->total_tagihan_ipl;
        $connMonthlyTenant->total_tagihan_utility = $createUtilityBill->total_tagihan_utility;
        $connMonthlyTenant->total = $createIPLbill->total_tagihan_ipl + $createUtilityBill->total_tagihan_utility + $connMonthlyTenant->denda_bulan_sebelumnya;

        return $connMonthlyTenant;
    }

    public function createIPLbill($elecUSS)
    {
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connIPL = ConnectionDB::setConnection(new MonthlyIPL());
        $connIPLType = ConnectionDB::setConnection(new IPLType());

        $sc = $connIPLType->find(6);
        $sf = $connIPLType->find(7);
        $unit = $connUnit->find($elecUSS->id_unit);

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

    public function createTransaction($mt)
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

            $subtotal = $mt->total_tagihan_utility + $mt->total_tagihan_ipl + $mt->total_denda;
            $prevSubTotal = 0;
            $total_denda = 0;

            if ($mt->PreviousMonthBill()) {
                foreach ($mt->PreviousMonthBill() as $key => $prevBill) {
                    $prevSubTotal += $prevBill->total_tagihan_utility + $prevBill->total_tagihan_ipl + $prevBill->total_denda;
                    $total_denda += $prevBill->total_denda;

                    $connCRd = ConnectionDB::setConnection(new CashReceiptDetail());
                    $connCRd->create([
                        'no_draft_cr' => $no_cr,
                        'ket_transaksi' => 'Pembayaran bulan IPL dan Utility ' . $prevBill->periode_bulan,
                        'tx_amount' => $prevSubTotal
                    ]);
                }
            }

            $amountInstallment = 0;
            $installment = $connInstallment->where('periode', $mt->periode_bulan)
                ->where('tahun', $mt->periode_tahun)
                ->first();

            if ($installment) {
                $amountInstallment = $installment->amount;
            }

            $subtotal = $subtotal + $prevSubTotal + $amountInstallment;

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
            $createTransaction->transaction_type = 'MonthlyTenant';

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

    public function blastMonthlyInvoice(Request $request)
    {
        $connReminder = ConnectionDB::setConnection(new ReminderLetter());
        $connElec = ConnectionDB::setConnection(new ElectricUUS());
        $connWater = ConnectionDB::setConnection(new WaterUUS());

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

                $arTenant = $util->MonthlyUtility->MonthlyTenant;

                if (!$arTenant->tgl_jt_invoice && !$arTenant->tgl_bayar_invoice) {
                    $jatuh_tempo_1 = $connReminder->find(1)->durasi_reminder_letter;
                    $jatuh_tempo_1 = Carbon::now()->addDays($jatuh_tempo_1);

                    $util->MonthlyUtility->MonthlyTenant->tgl_jt_invoice = $jatuh_tempo_1;
                    $util->MonthlyUtility->MonthlyTenant->save();

                    $util->MonthlyUtility->MonthlyTenant->MonthlyIPL->sign_approval_2 = Carbon::now();
                    $util->MonthlyUtility->MonthlyTenant->MonthlyIPL->save();

                    $util->MonthlyUtility->sign_approval_2 = Carbon::now();
                    $util->MonthlyUtility->save();

                    $dataNotif = [
                        'models' => 'MonthlyTenant',
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

    public function generatePaymentMonthly(Request $request, $id)
    {
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $mt = $connMonthlyTenant->find($id);
        $site = Site::find($mt->id_site);

        $client = new Client();
        $billing = explode(',', $request->billing);
        $admin_fee = $request->admin_fee;
        $transaction = $mt->CashReceipt;

        if ($transaction->transaction_status == 'PENDING') {
            if ($billing[0] == 'bank_transfer') {
                $transaction->gross_amount = $transaction->sub_total + $admin_fee;
                $transaction->payment_type = 'bank_transfer';
                $transaction->bank = Str::upper($billing[1]);
                $payment = [];

                $payment['payment_type'] = $billing[0];
                $payment['transaction_details']['order_id'] = $transaction->order_id;
                $payment['transaction_details']['gross_amount'] = (int) $transaction->gross_amount;
                $payment['bank_transfer']['bank'] = $billing[1];

                $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
                    'body' => json_encode($payment),
                    'headers' => [
                        'accept' => 'application/json',
                        'authorization' => 'Basic ' . base64_encode($site->midtrans_server_key),
                        'content-type' => 'application/json',
                    ],
                    "custom_expiry" => [
                        "order_time" => Carbon::now(),
                        "expiry_duration" => 1,
                        "unit" => "day"
                    ]
                ]);
                $response = json_decode($response->getBody());

                $transaction->va_number = $response->va_numbers[0]->va_number;
                $transaction->expiry_time = $response->expiry_time;
                $transaction->no_invoice = $mt->no_monthly_invoice;
                $transaction->admin_fee = $admin_fee;
                $transaction->transaction_status = 'VERIFYING';

                $transaction->save();
                $mt->save();

                return redirect()->route('paymentMonthly', [$mt->id_monthly_ar_tenant, $transaction->id]);
            } elseif ($request->billing == 'credit_card') {
                $transaction->payment_type = 'credit_card';
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = round($transaction->sub_total + $admin_fee);

                $getTokenCC = $this->TransactionCC($request);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction);

                $mt->no_monthly_invoice = $transaction->no_invoice;
                $mt->save();

                $transaction->save();

                return redirect($chargeCC->redirect_url);
            }
        } else {
            return redirect()->back();
        }
    }

    public function ChargeTransactionCC($token, $transaction)
    {
        $login = Auth::user();
        $site = Site::find($login->id_site);
        $server_key = $site->midtrans_server_key;

        try {
            $credit_card = array(
                'token_id' => $token,
                'authentication' => true,
                'bank' => 'bni'
            );

            $transactionData = array(
                "payment_type" => "credit_card",
                "transaction_details" => [
                    "gross_amount" => $transaction->gross_amount,
                    "order_id" => $transaction->order_id
                ],
            );

            $transactionData["credit_card"] = $credit_card;
            $result = CoreApi::charge($transactionData, $server_key);

            return $result;
        } catch (Throwable $e) {
            dd($e);
        }
    }

    public function TransactionCC($request)
    {
        $expDate = explode('/', $request->expDate);
        $card_exp_month = $expDate[0];
        $card_exp_year = $expDate[1];

        $login = Auth::user();
        $site = Site::find($login->id_site);

        try {
            $token = CoreApi::cardToken(
                $request->card_number,
                $card_exp_month,
                $card_exp_year,
                $request->card_cvv,
                $site->midtrans_client_key
            );

            if ($token->status_code != 200) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }

            return $token;
        } catch (\Throwable $e) {
            dd($e);
            return ResponseFormatter::error([
                'message' => 'Internar Error'
            ], 'Something went wrong', 500);
        }

        return response()->json(['token' => $token]);
    }

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
