<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionDB;
use App\Models\Transaction;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    public function receive()
    {
        $connTransaction = ConnectionDB::setConnection(new Transaction());
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                $connTransaction->where('no_invoice', $order->id)->update([
                    'status' => 'PAYED',
                ]);
            }

            if ($callback->isExpire()) {
                $connTransaction->where('no_invoice', $order->id)->update([
                    'status' => 'EXPIRED',
                ]);
            }

            if ($callback->isCancelled()) {
                $connTransaction->where('no_invoice', $order->id)->update([
                    'status' => 'CANCELLED',
                ]);
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

    public function delete()
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('DELETE', 'https://api.sandbox.midtrans.com/v1/payment-links/SANDBOX-G014143018-523', [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic U0ItTWlkLXNlcnZlci1VQkJEOVpMcUdRRFBPd2VpekdkSGFnTFo6',
              ],
        ]);

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
