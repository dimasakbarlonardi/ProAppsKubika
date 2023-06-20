<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\WorkOrder;
use App\Models\WorkRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function notifications(Request $request)
    {
        $user = $request->session()->get('user');
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $data['notifications'] = $connNotif->where('receiver', $user->id_user)
        ->with(['Sender'])
        ->latest()
        ->get();

        return view('Tenant.Notification.index', $data);
    }

    public function getNotifications(Request $request)
    {
        $user = $request->session()->get('user');

        $receiver = $request->receiver;
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $notifications = $connNotif->where('receiver', $receiver)
        ->orWhere('division_receiver', $user->RoleH->work_relation_id)
        ->with(['sender'])
        ->latest()
        ->get();

        return response()->json($notifications);
    }

    public function showNotification($id)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $getNotif = $connNotif->find($id);

        $getNotif->is_read = 1;
        $getNotif->save();

        switch($getNotif->models) {
            case('WorkOrder'):
                $model = new WorkOrder();
                $getData = ConnectionDB::setConnection($model);
                $data['wo'] = $getData->find($getNotif->id_data);
                return view('Tenant.Notification.WorkOrder', $data);
            break;

            case('WorkRequest'):
                $model = new WorkRequest();
                $getData = ConnectionDB::setConnection($model);
                $data['wr'] = $getData->find($getNotif->id_data);
                return view('Tenant.Notification.WorkRequest', $data);
            break;
        }
    }
}
