<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Site;
use Midtrans\CoreApi;
use App\Models\System;
use GuzzleHttp\Client;
use App\Models\WorkOrder;
use App\Models\CashReceipt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\HelpNotifikasi;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class WorkOrderController extends Controller
{
    public function show($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->where('id', $id)
        ->with(['Ticket', 'WODetail', 'Ticket.CashReceipt'])
        ->first();

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function acceptWO($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        $createTransaction = $this->createTransaction($wo);

        HelpNotifikasi::paymentWO($id, $createTransaction);

        return ResponseFormatter::success(
            $wo,
            'Success approve WO'
        );
    }

    public function createTransaction($wo)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $system = $connSystem->find(1);
        $request = Request();
        $user = $request->user();

        $count = $system->sequence_no_cash_receiptment + 1;
        $countINV = $system->sequence_no_invoice + 1;

        $no_cr = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_cash_receipt . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $no_inv = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $countINV);

        $order_id = $user->id_site . '-' . $no_cr;

        try {
            DB::beginTransaction();

            $createTransaction = $connTransaction;
            $createTransaction->order_id = $order_id;
            $createTransaction->id_site = $user->id_site;
            $createTransaction->no_reff = $wo->no_work_order;
            $createTransaction->no_draft_cr = $no_cr;
            $createTransaction->ket_pembayaran = 'WO/' . $wo->Ticket->Tenant->User->id_user . '/' . $wo->Ticket->Unit->nama_unit;
            $createTransaction->sub_total = $wo->jumlah_bayar_wo;
            $createTransaction->no_invoice = $no_inv;
            $createTransaction->transaction_status = 'PENDING';
            $createTransaction->id_user = $wo->Ticket->Tenant->User->id_user;
            $createTransaction->transaction_type = 'WorkOrder';
            $createTransaction->save();

            $system->sequence_no_cash_receiptment = $count;
            $system->sequence_no_invoice = $countINV;

            $createTransaction->WorkOrder->Ticket->no_invoice = $no_inv;
            $createTransaction->WorkOrder->Ticket->save();

            $system->save();

            DB::commit();
        } catch (Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back();
        }

        return $createTransaction;
    }

    public function generatePaymentWO(Request $request, $id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $client = new Client();

        $wo = $connWO->find($id);
        $transaction = $wo->Ticket->CashReceipt;
        $site = Site::find($wo->Ticket->id_site);

        $client = new Client();
        $admin_fee = (int) $request->admin_fee;
        $type = $request->type;
        $bank = $request->bank;
        $transaction = $wo->Ticket->CashReceipt;

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
                $transaction->admin_fee = $admin_fee;
                $transaction->transaction_status = 'VERIFYING';
                $transaction->save();

                return ResponseFormatter::success(
                    $response,
                    'Authenticated'
                );
            } elseif ($type == 'credit_card') {
                $transaction->payment_type = 'credit_card';
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = round($transaction->sub_total + $admin_fee);
                $transaction->transaction_status = 'VERIFYING';

                $getTokenCC = $this->TransactionCC($request, $site);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction, $site);

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

    public function TransactionCC($request, $site)
    {
        $expDate = explode('/', $request->expDate);
        $card_exp_month = $expDate[0];
        $card_exp_year = $expDate[1];

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

    public function ChargeTransactionCC($token, $transaction, $site)
    {
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
}