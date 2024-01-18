<?php

namespace App\Http\Controllers;

use App\Events\HelloEvent;
use App\Events\PaymentEvent;
use App\Helpers\ConnectionDB;
use App\Models\Approve;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
use App\Models\IPLType;
use App\Models\MonthlyArTenant;
use App\Models\Site;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\Utility;
use App\Services\Midtrans\CallbackService;
use PDF;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;
use JWTAuth;

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
                $cr->transaction_status = 'PAID';
                $cr->settlement_time = $callback->getNotification()->settlement_time;

                switch ($cr->transaction_type) {
                    case ('WorkOrder'):
                        $cr->WorkOrder->sign_approve_5 = 1;
                        $cr->WorkOrder->date_approve_5 = Carbon::now();
                        $cr->WorkOrder->save();

                        $dataNotif = [
                            'models' => 'MApproveWorkOrder',
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
                            'models' => 'MApproveWorkOrder',
                            'notif_title' => $cr->WorkOrder->no_work_order,
                            'id_data' => $cr->WorkOrder->id,
                            'sender' => $cr->WorkOrder->Ticket->Tenant->User->id_user,
                            'division_receiver' => 1,
                            'notif_message' => 'Pembayaran Work Order berhasil, terima kasih',
                            'receiver' => null,
                            'connection' => $site->db_name
                        ];

                        broadcast(new HelloEvent($dataNotifTR));

                        break;

                    case ('WorkPermit'):
                        $cr->WorkPermit->status_bayar = 'PAID';
                        $cr->WorkPermit->sign_approval_5 = Carbon::now();
                        $cr->WorkPermit->save();

                        $approve = $approve->find(5);

                        $dataNotif = [
                            'models' => 'WorkPermit',
                            'notif_title' => $cr->WorkPermit->no_work_permit,
                            'id_data' => $cr->WorkPermit->id,
                            'sender' => $cr->WorkPermit->Ticket->Tenant->User->id_user,
                            'division_receiver' => 6,
                            'notif_message' => 'Pembayaran Work Permit berhasil',
                            'receiver' => $approve->approval_4,
                            'connection' => $site->db_name
                        ];

                        broadcast(new HelloEvent($dataNotif));

                        break;

                    case ('Reservation'):
                        $cr->Reservation->status_bayar = 'PAID';
                        $cr->Reservation->sign_approval_5 = Carbon::now();
                        $cr->Reservation->save();

                        $cr->Reservation->Ticket->status_request = 'APPROVED';
                        $cr->Reservation->Ticket->save();

                        $dataNotif = [
                            'models' => 'Reservation',
                            'notif_title' => $cr->Reservation->no_request_reservation,
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
                        $this->monthly($site, $cr, $callback);
                        break;

                    case ('MonthlyUtilityTenant'):
                        $this->monthly($site, $cr, $callback);
                        break;

                    case ('MonthlyIPLTenant'):
                        $this->monthly($site, $cr, $callback);
                        break;
                }
            }

            $dataPayment = [
                'id_site' => $site->id_site,
                'id' => $cr->id,
                'status' => 'settlement',
            ];

            broadcast(new PaymentEvent($dataPayment));

            if ($callback->isExpire()) {
                $cr->transaction_status = 'PENDING';
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

    function monthly($site, $cr, $callback)
    {
        $setting = new CompanySetting();
        $bills = new MonthlyArTenant();

        $bills = $bills->setConnection($site->db_name);
        $setting = $setting->setConnection($site->db_name);
        $setting = $setting->find(1);

        if ($setting->is_split_ar == 0) {
            $bills = $bills->where('id_unit', $cr->MonthlyARTenant->id_unit)->get();

            foreach ($bills as $bill) {
                $installment = $cr->UpdateInstallment($bill->periode_bulan, $bill->periode_tahun, $site->db_name);
                if ($installment) {
                    $installment->status = 'PAID';
                    $installment->save();
                }
                $bill->tgl_bayar_invoice = Carbon::now();
                $bill->save();
            }
        } elseif ($setting->is_split_ar == 1) {
            $bills = $bills->where('id_unit', $cr->SplitMonthlyARTenantNotif($cr->id_monthly_utility, $cr->id_monthly_ipl, $site->db_name)->id_unit)->get();

            foreach ($bills as $bill) {
                if ($cr->id_monthly_utility) {
                    $bill->tgl_bayar_utility = $callback->getNotification()->settlement_time;
                }
                if ($cr->id_monthly_ipl) {
                    $bill->tgl_bayar_ipl = $callback->getNotification()->settlement_time;
                }

                $bill->save();
            }
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

    public function invoice(Request $request)
    {
        $connUtility = new Utility();
        $connIPLType = new IPLType();
        $connSetting = new CompanySetting();
        $connCR = new CashReceipt();

        $connUtility = $connUtility->setConnection($request->site);
        $connIPLType = $connIPLType->setConnection($request->site);
        $connSetting = $connSetting->setConnection($request->site);
        $connCR = $connCR->setConnection($request->site);

        $setting = $connSetting->find(1);
        $cr = $connCR->find($request->id);

        if ($cr->Unit->id_hunian == 1) {
            $data['electric'] = $connUtility->find(1);
            $data['water'] = $connUtility->find(2);
            $data['sc'] = $connIPLType->find(6);
            $data['sf'] = $connIPLType->find(7);
        } else {
            $data['electric'] = $connUtility->find(3);
            $data['water'] = $connUtility->find(4);
            $data['sc'] = $connIPLType->find(8);
            $data['sf'] = $connIPLType->find(9);
        }

        $data['setting'] = $setting;
        $data['transaction'] = $cr;

        if ($request->type == "utility") {
            $html = 'Tenant.Notification.Invoice.Download.Utility_bill';
        } elseif ($request->type == 'ipl') {
            $html = 'Tenant.Notification.Invoice.Download.IPL_bill';
        } elseif ($request->type == 'other') {
            $html = 'Tenant.Notification.Invoice.Download.Other_bill';
        }

        return view($html, $data);
    }

    public function invoiceAPI($id)
    {
        $connCR = ConnectionDB::setConnection(new CashReceipt());
        $cr = $connCR->find($id);



        if ($cr->transaction_type == 'MonthlyUtilityTenant') {
            return view('Tenant.Notification.Invoice.SplitPaymentMonthly.Utility_bill');
        }
    }
}
