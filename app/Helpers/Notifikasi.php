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
        dd($woID, $transaction);
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $wo = $connWO->find($woID);

        $notif = $connNotif->where('models', 'PaymentWO')
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
            $createNotif->models = 'PaymentWO';
            $createNotif->save();
        }
    }

    public function paymentMonthlyTenant($mt)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $request = Request();

        $notif = $connNotif->where('models', 'MonthlyTenant')
            ->where('is_read', 0)
            ->where('id_data', $mt->id_monthly_ar_tenant)
            ->first();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $request->session()->get('user')->id_user;
            $createNotif->receiver = $mt->Unit->TenantUnit->Tenant->User->id_user;
            $createNotif->is_read = 0;
            $createNotif->id_data = $mt->id_monthly_ar_tenant;
            $createNotif->notif_title = 'Invoice Bulanan';
            $createNotif->notif_message = 'Harap melakukan pembayaran tagihan bulanan anda';
            $createNotif->models = 'MonthlyTenant';
            $createNotif->save();
        }
    }
}
