<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\BAPP;
use App\Models\CashReceipt;
use App\Models\JenisRequest;
use App\Models\Karyawan;
use App\Models\MonthlyArTenant;
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
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkPermit;
use App\Models\WorkPriority;
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

    public function getNotifications(Request $request, $userID)
    {
        $login = $request->session()->get('user');
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $login->login_user)->first();

        $work_relation = $user->RoleH->work_relation_id;

        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $notifications = $connNotif->where('receiver', $userID)
            ->orWhere('division_receiver', $work_relation)
            ->with(['sender'])
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json($notifications);
    }

    public function getNewNotifications(Request $request, $notifID)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $notifications = $connNotif->where('deleted_at', null)
            ->with('Sender')
            ->find($notifID);

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


        $checkDivision = $user->RoleH->WorkRelation->id_work_relation == $getNotif->division_receiver;
        if ($checkDivision) {
            $isDivision = true;
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

        switch ($getNotif->models) {
            case ('WorkOrder'):
                $data = $this->handleWO($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.WorkOrder', $data);
                break;

            case ('WorkOrderM'):
                return redirect()->route('work-orders.show', $getNotif->id_data);
                break;

            case ('WorkRequest'):
                $data = $this->handleWR($connApprove, $getNotif);
                $data['user'] = $user;
                return redirect()->route('work-requests.show', $getNotif->id_data);
                break;

            case ('WorkRequestT'):
                $data = $this->handleWR($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.WorkRequest', $data);
                break;

            case ('MonthlyTenant'):
                $data = $this->handleMonthlyTenant($getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.Payment', $data);
                break;

            case ('OpenTicket'):
                $data = $this->handleRequest($connApprove, $getNotif);
                $connJR = ConnectionDB::setConnection(new JenisRequest());

                $data['user'] = $user;
                $data['jenis_requests'] = $connJR->get();

                return view('AdminSite.OpenTicket.show', $data);
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
                $data['notif'] = $getNotif;
                return view('Tenant.Notification.Reservation', $data);
                break;

            case ('PaymentReservation'):
                $data = $this->handlePaymentReservation($getNotif);
                return view('Tenant.Notification.Payment', $data);
                break;

            case ('GIGO'):
                $data = $this->handleGIGO($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.GIGO', $data);
                break;

            case ('PaymentWO'):
                $data = $this->handlePaymentWO($getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.Payment', $data);
                break;

            case ('UpdateWaterRecording'):
                return redirect()->route('uus-water');
                break;

            case ('UpdateElectricRecording'):
                return redirect()->route('usr-electric');
                break;
        }
    }

    public function handleRequest($connApprove, $getNotif)
    {
        $model = new OpenTicket();
        $getData = ConnectionDB::setConnection($model);
        $connPriority = ConnectionDB::setConnection(new WorkPriority());

        $data['sysApprove'] = $connApprove->find(1);
        $data['ticket'] = $getData->find($getNotif->id_data);
        $data['work_priorities'] = $connPriority->get();

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

    public function handleMonthlyTenant($getNotif)
    {
        $model = new MonthlyArTenant();
        $getData = ConnectionDB::setConnection($model);
        $getData = $getData->find($getNotif->id_data);
        $data['transaction'] = $getData->where('id_monthly_ar_tenant', $getData->id_monthly_ar_tenant)->first();
        $data['type'] = 'MonthlyTenant';

        return $data;
    }

    public function handlePaymentWO($getNotif)
    {
        $model = new CashReceipt();
        $getData = ConnectionDB::setConnection($model);
        $getData = $getData->find($getNotif->id_data);
        $data['transaction'] = $getData->where('id', $getData->id)->first();
        $data['type'] = 'wo';

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
    public function handlePaymentReservation($getNotif)
    {
        $model = new Reservation();
        $getData = ConnectionDB::setConnection($model);
        $rsv =  $getData->find($getNotif->id_data);
        $data['reservation'] = $rsv;
        $data['type'] = 'Reservation';

        return $data;
    }

    public function handleGIGO($connApprove, $getNotif)
    {
        $model = new RequestGIGO();
        $getData = ConnectionDB::setConnection($model);
        $data['sysApprove'] = $connApprove->find(8);
        $gigo =  $getData->find($getNotif->id_data);
        $data['gigo'] = $gigo;

        return $data;
    }
}
