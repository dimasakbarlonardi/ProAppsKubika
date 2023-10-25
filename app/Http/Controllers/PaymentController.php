<?php

namespace App\Http\Controllers;

use App\Events\HelloEvent;
use App\Events\PaymentEvent;
use App\Helpers\ConnectionDB;
use App\Models\Approve;
use App\Models\CashReceipt;
use App\Models\MonthlyArTenant;
use App\Models\Site;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Services\Midtrans\CallbackService;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;
        if ($callback->isSignatureKeyVerified()) {
            $order = $callback->getOrder();
            $site = Site::find($order->id_site);

            $cr = new CashReceipt();
            $cr = $cr->setConnection($site->db_name);
            $cr = $cr->where('no_draft_cr', $order->no_draft_cr)->first();

            $approve = new Approve();
            $approve = $approve->setConnection($site->db_name);
            $approve = $approve->find(7);

            if ($callback->isSuccess()) {
                $cr->transaction_status = 'PAYED';

                switch ($cr->transaction_type) {
                    case ('WorkOrder'):
                        $cr->WorkOrder->sign_approve_5 = 1;
                        $cr->WorkOrder->date_approve_5 = Carbon::now();
                        $cr->WorkOrder->save();

                        $dataNotif = [
                            'models' => 'WorkOrder',
                            'notif_title' => $cr->WorkOrder->no_work_order,
                            'id_data' => $cr->WorkOrder->id,
                            'sender' => $cr->WorkOrder->Ticket->Tenant->User->id_user,
                            'division_receiver' => $cr->WorkOrder->WorkRequest->id_work_relation,
                            'notif_message' => 'Pembayaran Work Order berhasil, terima kasih',
                            'receiver' => null,
                            'connection' => $site->db_name
                        ];

                        broadcast(new HelloEvent($dataNotif));

                        $dataNotifTR = [
                            'models' => 'WorkOrder',
                            'notif_title' => $cr->WorkOrder->no_work_order,
                            'id_data' => $cr->WorkOrder->id,
                            'sender' => $cr->WorkOrder->Ticket->Tenant->User->id_user,
                            'division_receiver' => 1,
                            'notif_message' => 'Pembayaran Work Order berhasil, terima kasih',
                            'receiver' => null,
                            'connection' => $site->db_name
                        ];

                        broadcast(new HelloEvent($dataNotifTR));

                        $dataPayment = [
                            'id_site' => $site->id_site,
                            'id' => $cr->id,
                            'status' => 'settlement',
                        ];

                        broadcast(new PaymentEvent($dataPayment));

                        break;

                    case ('WorkPermit'):
                        $cr->WorkPermit->status_bayar = 'PAYED';
                        $cr->WorkPermit->sign_approval_5 = Carbon::now();
                        $cr->WorkPermit->save();

                        $approve = $approve->find(5);

                        $dataNotif = [
                            'models' => 'WorkPermit',
                            'notif_title' => $cr->WorkPermit->no_work_permit,
                            'id_data' => $cr->WorkPermit->id,
                            'sender' => $cr->WorkPermit->Ticket->Tenant->User->id_user,
                            'division_receiver' => null,
                            'notif_message' => 'Pembayaran Work Permit berhasil',
                            'receiver' => $approve->approval_4,
                            'connection' => $site->db_name
                        ];

                        broadcast(new HelloEvent($dataNotif));

                        $dataPayment = [
                            'id_site' => $site->id_site,
                            'id' => $cr->id,
                            'status' => 'settlement',
                        ];

                        broadcast(new PaymentEvent($dataPayment));

                        break;

                    case ('Reservation'):
                        $cr->Reservation->status_bayar = 'PAYED';
                        $cr->Reservation->sign_approval_5 = Carbon::now();
                        $cr->Reservation->save();

                        $dataNotif = [
                            'models' => 'Reservation',
                            'notif_title' => $cr->Reservation->no_reservation,
                            'id_data' => $cr->Reservation->id,
                            'sender' => $cr->Reservation->Ticket->Tenant->User->id_user,
                            'division_receiver' => 1,
                            'notif_message' => 'Pembayaran berhasil, mohon approve proses reservasi',
                            'receiver' => $approve->approval_3,
                            'connection' => $site->db_name
                        ];

                        broadcast(new HelloEvent($dataNotif));

                        break;

                    case ('MonthlyTenant'):
                        $bills = new MonthlyArTenant();
                        $bills = $bills->setConnection($site->db_name);
                        $bills = $bills->where('id_unit', $cr->MonthlyARTenant->id_unit)->get();

                        foreach ($bills as $bill) {
                            $bill->tgl_bayar_invoice = Carbon::now();
                            $bill->save();
                        }

                        break;
                }
            }

            if ($callback->isExpire()) {
                $cr->transaction_status = 'EXPIRED';
            }

            if ($callback->isCancelled()) {
                $cr->transaction_status = 'CANCELLED';
            }

            $cr->save();

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification successfully processed',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key not verified',
                ], 403);
        }
    }

    public function checkStatus($id)
    {
        $connTransaction = ConnectionDB::setConnection(new CashReceipt());

        $transaction = $connTransaction->find($id);

        if ($transaction->transaction_status == 'VERIFYING' || $transaction->transaction_status == 'PENDING') {
            $status = 'no';
        } else {
            $status = 'ok';
        }
        return response()->json(['status' => $status]);
    }

    public function invoice($id)
    {
        $request = Request();
        $site = Site::find($request->user()->id_site);
        $connCR = new CashReceipt();
        $connCR = $connCR->setConnection($site->db_name);
        $cr = $connCR->find($id);

        $data['cr'] = $cr;

        return view('Tenant.invoice', $data);
    }

    public function invoiceAPI($id)
    {
        $request = Request();
        $site = Site::find($request->user()->id_site);
        $connCR = new CashReceipt();
        $connCR = $connCR->setConnection($site->db_name);
        $cr = $connCR->find($id);

        $data['cr'] = $cr;

        return response()->json([
            'invoice' => view('Tenant.invoice', $data)->render()
        ]);
    }
}
