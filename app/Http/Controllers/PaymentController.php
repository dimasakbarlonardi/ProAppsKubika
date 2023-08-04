<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionDB;
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

            if ($callback->isSuccess()) {
                $cr->transaction_status = 'PAYED';

                switch ($cr->transaction_type) {
                    case ('WorkOrder'):
                        dd($cr);
                        $cr->WorkOrder->sign_approve_5 = 1;
                        $cr->WorkOrder->date_approve_5 = Carbon::now();
                        $cr->WorkOrder->save();
                        break;

                    case ('WorkPermit'):
                        dd($cr);

                        $cr->WorkPermit->status_bayar = 'PAYED';
                        $cr->WorkPermit->sign_approval_5 = Carbon::now();
                        $cr->WorkPermit->save();
                        break;

                    case ('Reservation'):
                        dd($cr);

                        $cr->Reservation->status_bayar = 'PAYED';
                        $cr->Reservation->sign_approval_5 = Carbon::now();
                        $cr->Reservation->save();
                        break;

                    case ('MonthlyTenant'):
                        $bills = new MonthlyArTenant();
                        $bills = $bills->setConnection($site->db_name);
                        $bills = $bills->where('id_unit', $cr->MonthlyARTenant->id_unit)->get();

                        foreach($bills as $bill) {
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
