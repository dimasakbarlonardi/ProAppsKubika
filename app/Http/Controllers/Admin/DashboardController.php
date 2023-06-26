<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\Transaction;
use App\Models\WorkOrder;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
            ->with(['sender'])
            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function showNotification(Request $request, $id)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $getNotif = $connNotif->find($id);
        $user = $request->session()->get('user');
        $isDivision = false;
        $isPass = false;

        if ($user->RoleH->work_relation_id == 4) {
            $checkDivision = $user->RoleH->WorkRelation->id_work_relation == $getNotif->division_receiver;
            if ($checkDivision) {
                $isDivision = true;
            }
        }

        $checkUser = $user->id_user == $getNotif->receiver;

        if ($checkUser || $isDivision) {
            $isPass = true;
        }

        if (!$isPass) {
            return redirect()->back();
        }

        $getNotif->is_read = 1;
        $getNotif->save();

        $data['user'] = $user;

        switch ($getNotif->models) {
            case ('WorkOrder'):
                $model = new WorkOrder();
                $getData = ConnectionDB::setConnection($model);
                $data['approve'] = $connApprove->find(3);
                $data['wo'] = $getData->find($getNotif->id_data);
                return view('Tenant.Notification.WorkOrder', $data);
                break;

            case ('WorkRequest'):
                $model = new WorkRequest();
                $getData = ConnectionDB::setConnection($model);
                $data['approve'] = $connApprove->find(2);
                $data['wr'] = $getData->find($getNotif->id_data);
                return view('Tenant.Notification.WorkRequest', $data);
                break;

            case ('Transaction'):
                $model = new Transaction();
                $getData = ConnectionDB::setConnection($model);
                $data['transaction'] = $getData->find($getNotif->id_data);
                return view('Tenant.Notification.Payment', $data);
                break;

            case ('OpenTicket'):
                $model = new OpenTicket();
                $getData = ConnectionDB::setConnection($model);
                $connSysApprove = ConnectionDB::setConnection(new Approve());
                $data['sysApprove'] = $connSysApprove->find(1);
                $data['ticket'] = $getData->find($getNotif->id_data);
                return view('Tenant.Notification.Ticket', $data);
                break;
        }
    }
}
