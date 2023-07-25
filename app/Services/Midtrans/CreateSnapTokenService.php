<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($transaction, $items)
    {
        parent::__construct();

        $this->transaction = $transaction;
        $this->items = $items;
    }

    public function getSnapToken()
    {
        $items = [];
        foreach($this->items as $item) {
            $items[] = [
                'id' => $item->id,
                'price' => $item->detil_biaya_alat,
                'quantity' => 1,
                'name' => $item->detil_pekerjaan
            ];
        }
        $items[] = [
            'id' => count($items) + 1,
            'price' => 5000,
            'quantity' => 1,
            'name' => 'Biaya admin'
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $this->transaction->order_id,
                'gross_amount' => $this->transaction->admin_fee + $this->transaction->subtotal,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $this->transaction->User->nama_user,
                'email' => $this->transaction->User->login_user,
                'phone' => $this->transaction->User->Tenant->no_telp_tenant,
            ]
        ];
        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
