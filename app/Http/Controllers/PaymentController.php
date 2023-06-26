<?php

namespace App\Http\Controllers;

use App\Helpers\ConnectionDB;
use App\Models\Transaction;

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
}
