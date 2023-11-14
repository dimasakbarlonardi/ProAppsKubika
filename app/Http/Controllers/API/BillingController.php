<?php

namespace App\Http\Controllers\API;

use App\Models\Site;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\CashReceiptDetail;
use App\Models\ElectricUUS;
use App\Models\IPLType;
use App\Models\ListBank;
use App\Models\MonthlyArTenant;
use Image;
use App\Models\System;
use Carbon\Carbon;
use App\Models\User;
use App\Models\WaterUUS;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Laravel\Sanctum\PersonalAccessToken;
use Midtrans\CoreApi;
use App\Models\Utility;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Throwable;

class BillingController extends Controller
{
    public function listBillings($id)
    {
        $dbName = ConnectionDB::getDBname();

        $connARTenant = DB::connection($dbName)
            ->table('tb_fin_monthly_ar_tenant as arm')
            ->join('tb_draft_cash_receipt as cr', 'arm.no_monthly_invoice', 'cr.no_reff')
            ->where('arm.id_unit', $id)
            ->where('arm.tgl_jt_invoice', '!=', null)
            ->orderBy('periode_bulan', 'desc')
            ->get();

        return ResponseFormatter::success(
            $connARTenant,
            'Authenticated'
        );
    }

    public function showBilling($id)
    {
        $connARTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $ar = $connARTenant->where('id_monthly_ar_tenant', $id);
        $connUtil = ConnectionDB::setConnection(new Utility());
        $connIPLType = ConnectionDB::setConnection(new IPLType());

        $sc = $connIPLType->find(6);
        $sf = $connIPLType->find(7);

        $data = $ar->with([
            'Unit.TenantUnit.Tenant',
            'CashReceipt',
            'MonthlyIPL',
            'MonthlyUtility.ElectricUUS',
            'MonthlyUtility.WaterUUS'
        ])
            ->first();
        $previousBills = $ar->first()->PreviousMonthBill();

        $data['price_water'] = $connUtil->find(2)->biaya_m3;
        $data['price_electric'] = $connUtil->find(1)->biaya_m3;
        $data['service_charge_price'] = $sc->biaya_permeter;
        $data['sinking_fund_price'] = $sf->biaya_permeter;

        return ResponseFormatter::success(
            [
                'current_bill' => $data,
                'previous_bills' => $previousBills
            ],
            'Authenticated'
        );
    }

    public function generateTransaction($id)
    {
        $request = Request();
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $mt = $connMonthlyTenant->find($id);
        $site = Site::find($mt->id_site);

        $client = new Client();
        $admin_fee = (int) $request->admin_fee;
        $type = $request->type;
        $bank = $request->bank;
        $transaction = $mt->CashReceipt;

        if ($transaction->transaction_status == 'PENDING') {
            if ($type == 'bank_transfer') {
                $transaction->gross_amount = $transaction->sub_total + $admin_fee;
                $transaction->payment_type = 'bank_transfer';
                $transaction->bank = Str::upper($bank);
                $payment = [];

                $payment['payment_type'] = $type;
                $payment['transaction_details']['order_id'] = $transaction->order_id;
                $payment['transaction_details']['gross_amount'] = $transaction->gross_amount;
                $payment['bank_transfer']['bank'] = $bank;

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
                $transaction->transaction_id = $response->transaction_id;
                $transaction->expiry_time = $response->expiry_time;
                $transaction->no_invoice = $mt->no_monthly_invoice;
                $transaction->admin_fee = $admin_fee;
                $transaction->transaction_status = 'VERIFYING';

                $object = new stdClass();
                $object->due_date = $transaction->expiry_time;
                $object->va_number = $transaction->va_number;
                $object->total_bill_request = $transaction->sub_total;
                $object->admin_fee = $transaction->admin_fee;

                $tax = (int) $transaction->gross_amount * 0.11;
                $object->tax = $tax;
                $object->gross_amount = $transaction->gross_amount + $tax;

                $transaction->tax;
                $transaction->gross_amount;
                $transaction->save();

                return ResponseFormatter::success(
                    $object,
                    'Authenticated'
                );
            } elseif ($type == 'credit_card') {
                $transaction->payment_type = 'credit_card';
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = round($transaction->sub_total + $admin_fee);
                $transaction->no_invoice = $mt->no_monthly_invoice;

                $getTokenCC = $this->TransactionCC($request);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction);

                $transaction->save();

                return ResponseFormatter::success(
                    $chargeCC
                );
            }
        } else {
            return ResponseFormatter::success(
                'Transaction has created'
            );
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

    public function createTransaction($mt)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());
        $system = $connSystem->find(1);

        $user = $mt->Unit->TenantUnit->Tenant->User;

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

            $subtotal = $mt->total_tagihan_utility + $mt->total_tagihan_ipl + $mt->denda_bulan_sebelumnya;
            $prevSubTotal = 0;
            $total_denda = 0;

            if ($mt->PreviousMonthBill()) {
                foreach ($mt->PreviousMonthBill() as $key => $prevBill) {
                    $prevSubTotal += $prevBill->total_tagihan_utility + $prevBill->total_tagihan_ipl + $prevBill->denda_bulan_sebelumnya;
                    $total_denda += $prevBill->total_denda;

                    $connCRd = ConnectionDB::setConnection(new CashReceiptDetail());
                    $connCRd->create([
                        'no_draft_cr' => $no_cr,
                        'ket_transaksi' => 'Pembayaran bulan IPL dan Utility ' . $prevBill->periode_bulan,
                        'tx_amount' => $prevSubTotal
                    ]);
                }
            }

            $subtotal = $subtotal + $prevSubTotal;

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $no_inv;
            $createTransaction->no_invoice = $no_inv;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'INV/' . $user->id_user . '/' . $mt->Unit->nama_unit;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $subtotal;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $user->id_user;
            $createTransaction->transaction_type = 'MonthlyTenant';

            $system->sequence_no_cash_receiptment = $countCR;
            $system->sequence_no_invoice = $countINV;
            // $system->save();

            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back();
        }

        return $createTransaction;
    }

    public function insertElectricMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);

            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $object = new stdClass();
            $object->unit = $unit->nama_unit;
            $object->period = Carbon::now()->format('m');
            $object->current = count($unit->electricUUS) > 0 ? $unit->electricUUS[0]->nomor_listrik_awal : 0;
            $object->previous = count($unit->electricUUS) > 0 ? $unit->electricUUS[0]->nomor_listrik_akhir : 0;

            return ResponseFormatter::success(
                $object
            , 'Success get data');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function storeElectricMeter(Request $request, $unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);
        $user = $tokenable->tokenable;
        $site = Site::find($user->id_site);

        $connUnit = new Unit();
        $connUtility = new Utility();

        $connUnit = $connUnit->setConnection($site->db_name);
        $connUtility = $connUtility->setConnection($site->db_name);

        $unit = $connUnit->find($unitID);
        $listrik = $connUtility->find(1);
        $usage = $request->current - $request->previous;

        $isAbodemen = false;
        $biaya_usage = $listrik->biaya_m3;
        $get_ppj = $listrik->biaya_ppj / 100;
        $electric_capacity = $unit->electric_capacity;
        $abodemen = (40 * $electric_capacity) / 1000;

        if ($usage < $abodemen) {
            $isAbodemen = true;
            $usage = $abodemen;
        }
        if ($isAbodemen) {
            if ($listrik->abodemen != 0) {
                $total_usage = $biaya_usage * $usage;
            } else {
                $total_usage = $listrik->biaya_tetap;
            }
        } else {
            $total_usage = $biaya_usage * $usage;
        }
        $ppj = $get_ppj * $total_usage;
        $total = $total_usage + $ppj;

        if ($tokenable) {
            $login = $tokenable->tokenable;
            $site = Site::find($login->id_site);

            $user = new User();
            $user = $user->setConnection($site->db_name);
            $user = $user->where('login_user', $login->email)->first();

            $connElecUUS = new ElectricUUS();
            $connElecUUS = $connElecUUS->setConnection($site->db_name);

            $isExist = $connElecUUS->where('periode_bulan', $request->periode_bulan)
                ->where('periode_tahun',  Carbon::now()->format('Y'))
                ->where('id_unit', $unitID)->first();

            if ($isExist) {
                return response()->json(['status' => 'exist']);
            }

            $electricUUS = $connElecUUS->create([
                'periode_bulan' => $request->periode_bulan,
                'periode_tahun' => Carbon::now()->format('Y'),
                'id_unit' => $unitID,
                'nomor_listrik_awal' => $request->previous,
                'nomor_listrik_akhir' => $request->current,
                'usage' => $usage,
                'ppj' => $ppj,
                'total' => $total,
                'id_user' => $user->id_user
            ]);

            $imageData = $request->file('imageData');

            if ($imageData) {
                $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'electric-usage', $imageData);

                $electricUUS->image = $storagePath;
                $electricUUS->save();
            }

            return response()->json(['status' => 'ok']);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function insertWaterMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);
            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $object = new stdClass();
            $object->unit = $unit->nama_unit;
            $object->period = Carbon::now()->format('m');
            $object->current = count($unit->waterUUS) > 0 ? $unit->waterUUS[0]->nomor_air_awal : 0;
            $object->previous = count($unit->waterUUS) > 0 ? $unit->waterUUS[0]->nomor_air_akhir : 0;

            return ResponseFormatter::success(
                $object
            , 'Success get data');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function storeWaterMeter(Request $request, $unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);
        $usage = $request->current - $request->previous;
        $login = $tokenable->tokenable;
        $site = Site::find($login->id_site);

        $user = new User();
        $user = $user->setConnection($site->db_name);
        $user = $user->where('login_user', $login->email)->first();

        $connUtility = new Utility();

        $connUtility = $connUtility->setConnection($site->db_name);

        $water = $connUtility->find(2);

        $total_usage = $water->biaya_m3 * $usage;
        $total = $total_usage;

        if ($tokenable) {
            try {
                DB::beginTransaction();

                $connWaterUUS = new WaterUUS();
                $connWaterUUS = $connWaterUUS->setConnection($site->db_name);

                $isExist = $connWaterUUS->where('periode_bulan', $request->periode_bulan)
                    ->where('periode_tahun',  Carbon::now()->format('Y'))
                    ->where('id_unit', $unitID)->first();

                if ($isExist) {
                    return response()->json(['status' => 'exist']);
                }
                $waterUUS = $connWaterUUS->create([
                    'periode_bulan' => $request->periode_bulan,
                    'periode_tahun' => Carbon::now()->format('Y'),
                    'id_unit' => $unitID,
                    'nomor_air_awal' => $request->previous,
                    'abodemen' => $water->biaya_abodemen,
                    'total' => $total,
                    'nomor_air_akhir' => $request->current,
                    'usage' => $usage,
                    'id_user' => $user->id_user
                ]);
                $imageData = $request->file('imageData');

                if ($imageData) {
                    $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'water-usage', $imageData);

                    $waterUUS->image = $storagePath;
                    $waterUUS->save();
                }

                return response()->json(['status' => 'ok']);
                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e);
                Alert::error('Gagal', 'Gagal menambahkan data');

                return redirect()->back();
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function getTokenCC(Request $req)
    {
        $login = $req->user();
        $site = Site::find($login->id_site);

        try {
            $token = CoreApi::cardToken(
                $req->card_number,
                $req->card_exp_month,
                $req->card_exp_year,
                $req->card_cvv,
                $site->midtrans_client_key
            );

            if ($token->status_code != 200) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }

            return ResponseFormatter::success([
                $token
            ], 'Authenticated');
        } catch (\Throwable $e) {
            dd($e);
            return ResponseFormatter::error([
                'message' => 'Internar Error'
            ], 'Something went wrong', 500);
        }

        return response()->json(['token' => $token]);
    }

    public function adminFee(Request $request)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());

        $cr = $connCR->find($request->transaction_id);
        $subtotal = $cr->sub_total;

        if ($request->method == 'credit_card') {
            $admin_fee = 2000 + (0.029 * $subtotal);
            $tax_fee = 0.11 * $admin_fee;
            $grand_total = $subtotal + $admin_fee;
        } else {
            $admin_fee = 4000;
            $tax_fee = 0.11 * $admin_fee;
            $admin_fee = $admin_fee + $tax_fee;

            $total = $subtotal + $admin_fee;
            $tax = 0.11 * $total;
            $grand_total = $total + $tax;
        }

        return response()->json([
            'sub_total' => round($subtotal),
            'admin_fee' => round($admin_fee),
            'total' => round($total),
            'tax' => round($tax),
            'grand_total' => round($grand_total)
        ]);
    }

    public function listBank()
    {
        $connListBanks = ConnectionDB::setConnection(new ListBank());

        $data = $connListBanks->get();

        return ResponseFormatter::success(
            $data,
            'Success get list banks'
        );
    }
}
