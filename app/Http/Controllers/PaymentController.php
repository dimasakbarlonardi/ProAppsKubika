<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionDB;
use App\Models\CashReceipt;
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
                        $cr->WorkOrder->sign_approve_5 = 1;
                        $cr->WorkOrder->date_approve_5 = Carbon::now();
                        $cr->WorkOrder->save();
                        break;

                    case ('WorkPermit'):
                        $cr->WorkPermit->status_bayar = 'PAYED';
                        $cr->WorkPermit->sign_approval_5 = Carbon::now();
                        $cr->WorkPermit->save();
                        break;

                    case ('Reservation'):
                        $cr->Reservation->status_bayar = 'PAYED';
                        $cr->Reservation->sign_approval_5 = Carbon::now();
                        $cr->Reservation->save();
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

    public function delete(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $order_id = $request->id;
        $server_key = "Basic " . base64_encode(config('midtrans.server_key') . ':');
        $response = $client->request('DELETE', 'https://api.sandbox.midtrans.com/v1/payment-links/' . $order_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $server_key,
            ],
        ]);

        // $order_id = $request->id;
        // $apiURL = "https://api.sandbox.midtrans.com/v2/" . $order_id . "/status";
        // $server_key = "Basic " . base64_encode(config('midtrans.server_key') . ':');

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $apiURL);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Accept: application/json',
        //     'Content-Type: application/json',
        //     'Authorization: ' . $server_key
        // ));
        // curl_exec($ch);

        echo $response->getBody();
    }

    public function check(Request $request)
    {
        $order_id = $request->id;
        $apiURL = "https://api.sandbox.midtrans.com/v2/" . $order_id . "/status";
        $server_key = "Basic " . base64_encode(config('midtrans.server_key') . ':');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $server_key
        ));
        curl_exec($ch);
    }
}
