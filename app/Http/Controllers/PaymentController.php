<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionDB;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Services\Midtrans\CallbackService;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;
        if ($callback->isSignatureKeyVerified()) {            
            $order = $callback->getOrder();
            // dd($order->Site->db_name);
            $ct = TransactionCenter::find($order->id);
            $transaction = new Transaction();
            $transaction = $transaction->setConnection($order->Site->db_name);
            $transaction = $transaction->where('no_invoice', $ct->no_invoice)->first();
          
            if ($callback->isSuccess()) {
                $ct->status = 'PAYED';
                $transaction->WorkOrder->sign_approve_4 = 1;
                $transaction->WorkOrder->save();
            }

            if ($callback->isExpire()) {
                $ct->status = 'EXPIRED';

            }

            if ($callback->isCancelled()) {
                $ct->status = 'CANCELLED';                
            }

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
