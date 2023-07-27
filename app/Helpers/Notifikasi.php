<?php

namespace App\Helpers;

use App\Helpers\ConnectionDB;
use App\Models\Approve;
use App\Models\ElectricUUS;
use App\Models\Notifikasi;
use App\Models\WorkOrder;
use Symfony\Component\HttpFoundation\Request;

class HelpNotifikasi
{
    public function paymentWO($woID, $transaction)
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $wo = $connWO->find($woID);

        $notif = $connNotif->where('models', 'CashReceipt')
            ->where('is_read', 0)
            ->where('id_data', $transaction->id)
            ->first();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $connApprove->find(3)->approval_4;
            $createNotif->receiver = $wo->Ticket->Tenant->User->id_user;
            $createNotif->is_read = 0;
            $createNotif->id_data = $transaction->id;
            $createNotif->notif_title = $wo->no_work_order;
            $createNotif->notif_message = 'Harap melakukan pembayaran untuk menselesaikan transaksi';
            $createNotif->models = 'CashReceipt';
            $createNotif->save();
        }
    }

    public function paymentElecUSS($dataElec, $transaction)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $request = Request();

        $notif = $connNotif->where('models', 'CashReceipt')
            ->where('is_read', 0)
            ->where('id_data', $transaction->id)
            ->first();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $request->session()->get('user')->id_user;
            $createNotif->receiver = $dataElec->Unit->TenantUnit->Tenant->User->id_user;
            $createNotif->is_read = 0;
            $createNotif->id_data = $transaction->id;
            $createNotif->notif_title = $dataElec->no_refrensi;
            $createNotif->notif_message = 'Harap melakukan pembayaran tagihan listrik anda';
            $createNotif->models = 'CashReceipt';
            $createNotif->save();
        }
    }
}
