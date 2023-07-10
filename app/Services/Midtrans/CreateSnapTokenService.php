<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($ct, $order, $items, $admin_fee)
    {
        parent::__construct();

        $this->ct = $ct;
        $this->order = $order;
        $this->items = $items;
        $this->admin_fee = $admin_fee;
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
                'order_id' => $this->ct->id,
                'gross_amount' => $this->admin_fee + $this->order->total,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $this->order->User->nama_user,
                'email' => $this->order->User->login_user,
                'phone' => $this->order->User->Tenant->no_telp_tenant,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
