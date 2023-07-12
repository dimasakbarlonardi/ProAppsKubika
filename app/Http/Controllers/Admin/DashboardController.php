<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\BAPP;
use App\Models\Karyawan;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\OwnerH;
use App\Models\RequestGIGO;
use App\Models\RequestPermit;
use App\Models\Reservation;
use App\Models\Tenant;
use App\Models\Tower;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\Unit;
use App\Models\WorkOrder;
use App\Models\WorkPermit;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connWR = ConnectionDB::setConnection(new WorkRequest());
        $connWO = ConnectionDB::setConnection(new WorkOrder());
        $connBAPP = ConnectionDB::setConnection(new BAPP());
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());
        $connRSV = ConnectionDB::setConnection(new Reservation());
        $connTower = ConnectionDB::setConnection(new Tower());
        $connEmployee = ConnectionDB::setConnection(new Karyawan());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $data['entry_ticket'] = $connTicket->count();
        $data['wr'] = $connWR->count();
        $data['wo'] = $connWO->count();
        $data['bapp'] = $connBAPP->count();
        $data['gigo'] = $connGIGO->count();
        $data['rsv'] = $connRSV->count();
        $data['tower'] = $connTower->count();
        $data['karyawan'] = $connEmployee->count();
        $data['unit'] = $connUnit->count();
        $data['owner'] = $connOwner->count();
        $data['tenant'] = $connTenant->count();

        $data['complete_ticket'] = $connTicket->where('status_request', 'complete')->count();
        $data['progress_ticket'] = $connTicket->where('status_request', 'proses')
        ->orWhere('status_request', 'on work')
        ->count();

        return view('dashboard', $data);
    }

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
                $data = $this->handleWO($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.WorkOrder', $data);
                break;

            case ('WorkRequest'):
                $data = $this->handleWO($connApprove, $getNotif);
                return view('Tenant.Notification.WorkRequest', $data);
                break;

            case ('Transaction'):
                $data = $this->handleTransaction($getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.Payment', $data);
                break;

            case ('OpenTicket'):
                $data = $this->handleTransaction($connApprove, $getNotif);
                return view('Tenant.Notification.Ticket', $data);
                break;

            case ('RequestPermit'):
                $data = $this->handleRP($connApprove, $getNotif);
                return view('Tenant.Notification.RequestPermit', $data);
                break;

            case ('WorkPermit'):
                $data = $this->handleWP($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.WorkPermit', $data);
                break;

            case ('BAPP'):
                $data = $this->handleBAPP($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.BAPP', $data);
                break;

            case ('Reservation'):
                $data = $this->handleReservation($getNotif);
                return view('Tenant.Notification.Reservation', $data);
                break;

            case ('GIGO'):
                $data = $this->handleGIGO($getNotif);
                return view('Tenant.Notification.GIGO', $data);
                break;
        }
    }

    public function handleRequest($connApprove, $getNotif)
    {
        $model = new OpenTicket();
        $getData = ConnectionDB::setConnection($model);
        $data['sysApprove'] = $connApprove->find(1);
        $data['ticket'] = $getData->find($getNotif->id_data);

        return $data;
    }

    public function handleWO($connApprove, $getNotif)
    {
        $model = new WorkOrder();
        $getData = ConnectionDB::setConnection($model);
        $data['approve'] = $connApprove->find(3);
        $data['wo'] = $getData->find($getNotif->id_data);

        return $data;
    }

    public function handleWR($connApprove, $getNotif)
    {
        $model = new WorkRequest();
        $getData = ConnectionDB::setConnection($model);
        $data['approve'] = $connApprove->find(2);
        $data['wr'] = $getData->find($getNotif->id_data);

        return $data;
    }

    public function handleTransaction($getNotif)
    {
        $model = new Transaction();
        $getData = ConnectionDB::setConnection($model);
        $getData = $getData->find($getNotif->id_data);
        $data['transaction'] = TransactionCenter::where('no_invoice', $getData->no_invoice)->first();

        return $data;
    }

    public function handleRP($connApprove, $getNotif)
    {
        $model = new RequestPermit();
        $getData = ConnectionDB::setConnection($model);
        $data['sysApprove'] = $connApprove->find(4);
        $permit =  $getData->find($getNotif->id_data);
        $data['permit'] = $permit;
        $dataJSON = json_decode($permit->RPDetail->data);
        $dataJSON = json_decode($dataJSON);
        $data['personels'] = $dataJSON->personels;
        $data['alats'] = $dataJSON->alats;
        $data['materials'] = $dataJSON->materials;

        return $data;
    }

    public function handleWP($connApprove, $getNotif)
    {
        $model = new WorkPermit();
        $getData = ConnectionDB::setConnection($model);
        $data['sysApprove'] = $connApprove->find(5);
        $permit =  $getData->find($getNotif->id_data);
        $data['permit'] = $permit;
        $dataJSON = json_decode($permit->RequestPermit->RPDetail->data);
        $dataJSON = json_decode($dataJSON);
        $data['personels'] = $dataJSON->personels;
        $data['alats'] = $dataJSON->alats;
        $data['materials'] = $dataJSON->materials;

        return $data;
    }

    public function handleBAPP($connApprove, $getNotif)
    {
        $model = new BAPP();
        $getData = ConnectionDB::setConnection($model);
        $data['sysApprove'] = $connApprove->find(6);
        $bapp =  $getData->find($getNotif->id_data);
        $data['bapp'] = $bapp;

        return $data;
    }

    public function handleReservation($getNotif)
    {
        $model = new Reservation();
        $getData = ConnectionDB::setConnection($model);
        $bapp =  $getData->find($getNotif->id_data);
        $data['reservation'] = $bapp;

        return $data;
    }

    public function handleGIGO($getNotif)
    {
        $model = new RequestGIGO();
        $getData = ConnectionDB::setConnection($model);
        $gigo =  $getData->find($getNotif->id_data);
        $data['gigo'] = $gigo;

        return $data;
    }
}
