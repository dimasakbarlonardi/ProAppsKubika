<?php

namespace App\Services\Midtrans;

use App\Helpers\ConnectionDB;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Services\Midtrans\Midtrans;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $serverKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = config('midtrans.server_key');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        $key = $this->notification;
        $orderId = $key->order_id;
        $statusCode = $key->status_code;
        $grossAmount = $key->gross_amount;
        $serverKey = $this->serverKey;
        $input = $orderId . $statusCode . (int) $grossAmount . $serverKey;
        $signature = openssl_digest($input, 'sha512');

        return ($this->_createLocalSignatureKey() == $signature);
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }

    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }

    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getOrder()
    {
        return $this->order;
    }

    protected function _createLocalSignatureKey()
    {
        $orderId = $this->order->id;
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->order->total;
        $serverKey = $this->serverKey;
        $input = $orderId . $statusCode . (int) $grossAmount . $serverKey;
        $signature = openssl_digest($input, 'sha512');

        return $signature;
    }

    protected function _handleNotification()
    {
        $notification = new Notification();
        $orderNumber = $notification->order_id;
        $order = TransactionCenter::find($orderNumber);
        $this->notification = $notification;

        $this->order = $order;
    }
}
