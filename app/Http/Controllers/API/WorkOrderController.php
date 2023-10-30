<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
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
use stdClass;

class WorkOrderController extends Controller
{
    public function show($id)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->where('id', $id)
            ->with(['Ticket.Tenant', 'WODetail', 'Ticket.Unit'])
            ->first();
        $wo->Ticket->deskripsi_request = strip_tags($wo->Ticket->deskripsi_request);
        $wo->Ticket->deskripsi_respon = strip_tags($wo->Ticket->deskripsi_respon);

        return ResponseFormatter::success(
            $wo,
            'Success get WO'
        );
    }

    public function acceptWO($id, Request $request)
    {
        $connWorkOrder = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWorkOrder->find($id);

        $wo->status_wo = 'APPROVED';
        $wo->sign_approve_1 = '1';
        $wo->date_approve_1 = Carbon::now();
        $wo->save();

        $dataNotif = [
            'models' => 'WorkOrderM',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $wo->Ticket->Tenant->User->id_user,
            'division_receiver' => $wo->WorkRequest->id_work_relation,
            'notif_message' => 'Work order telah di terima, terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wo,
            'Success approve WO'
        );
    }

    public function rejectWO($id)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $wo = $connWO->find($id);

        $dataNotif = [
            'models' => 'WorkOrderM',
            'notif_title' => $wo->no_work_order,
            'id_data' => $wo->id,
            'sender' => $wo->Ticket->Tenant->User->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Maaf work request kali ini saya tolak..',
            'receiver' => null,
        ];

        $wo->status_wo = 'REJECTED';
        $wo->save();

        $wo->WorkRequest->status_request = 'REJECTED';
        $wo->WorkRequest->save();

        $wo->Ticket->status_request = 'REJECTED';
        $wo->Ticket->save();

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wo,
            'Success reject WO'
        );
    }

    public function showBilling($id, Request $request)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $site = Site::find($request->user()->id_site);

        $cr = $connCR->where('id', $id)
            ->with(['WorkOrder.WODetail', 'WorkOrder.Ticket.Tenant', 'WorkOrder.Ticket.Unit'])
            ->first();

        $object = new stdClass();
        $object->work_order_id = $cr->WorkOrder->id;
        $object->transaction_id = $cr->id;
        $object->no_invoice = $cr->no_invoice;
        $object->issued_date = $cr->created_at;
        $object->tenant_name = $cr->WorkOrder->Ticket->Tenant->nama_tenant;
        $object->tower = $cr->WorkOrder->Ticket->Unit->Tower->nama_tower;
        $object->tower = $cr->WorkOrder->Ticket->Unit->nama_unit;
        $object->site = $site->province;
        $object->site = $site->kode_pos;
        $object->tenant_email = $cr->WorkOrder->Ticket->Tenant->email_tenant;
        $object->phone_number_tenant = $cr->WorkOrder->Ticket->Tenant->no_telp_tenant;
        $object->bank = $cr->bank;
        $object->transaction_status = $cr->transaction_status;
        $object->payment_type = $cr->payment_type;
        $object->va_number = $cr->va_number;
        $object->expiry_time = $cr->expiry_time;
        $object->admin_fee = $cr->admin_fee;
        $object->gross_amount = $cr->gross_amount;
        $object->tax = $cr->tax;

        $request_details = [];
        foreach ($cr->WorkOrder->WODetail as $itemWO) {
            $item = new stdClass();
            $item->billing = $itemWO->detil_pekerjaan;
            $item->price = $itemWO->detil_biaya_alat;

            $request_details[] = $item;
        }

        $object->request_details = $request_details;
        $object->total = $cr->sub_total;

        return ResponseFormatter::success(
            $object,
            'Success get billing'
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
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $client = new Client();

        $cr = $connTransaction->find($id);

        $site = Site::find($cr->WorkOrder->Ticket->id_site);

        $client = new Client();
        $admin_fee = (int) $request->admin_fee;
        $type = $request->type;
        $bank = $request->bank;

        if ($cr->transaction_status == 'PENDING') {
            if ($type == 'bank_transfer') {
                $cr->gross_amount = $cr->sub_total + $admin_fee;
                $cr->payment_type = 'bank_transfer';
                $cr->bank = Str::upper($bank);

                $tax = $request->tax;
                $gross_amount = $cr->sub_total + $tax + $admin_fee;

                $payment = [];
                $payment['payment_type'] = $type;
                $payment['transaction_details']['order_id'] = $cr->order_id;
                $payment['transaction_details']['gross_amount'] = $gross_amount;
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

                $cr->va_number = $response->va_numbers[0]->va_number;
                $cr->transaction_id = $response->transaction_id;
                $cr->expiry_time = $response->expiry_time;
                $cr->admin_fee = $admin_fee;
                $cr->transaction_status = 'VERIFYING';

                $cr->tax = $tax;
                $cr->gross_amount = $gross_amount;
                $cr->save();

                return ResponseFormatter::success(
                    $response,
                    'Authenticated'
                );
            } elseif ($type == 'credit_card') {
                $cr->payment_type = 'credit_card';
                $cr->admin_fee = $admin_fee;
                $cr->gross_amount = round($cr->sub_total + $admin_fee);
                $cr->transaction_status = 'VERIFYING';

                $getTokenCC = $this->TransactionCC($request, $site);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $cr, $site);

                $cr->save();

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
