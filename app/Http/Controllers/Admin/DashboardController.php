<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\BAPP;
use App\Models\CashReceipt;
use App\Models\CompanySetting;
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
use App\Models\Utility;
use App\Models\IPLType;
use App\Models\JenisDenda;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkPermit;
use App\Models\WorkPriority;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\ReminderLetter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->get('user')) {
            Auth::guard('web')->logout();

            return redirect()->route('login');
        }
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connInvoice = ConnectionDB::setConnection(new CashReceipt());
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
        $user_id = $request->user()->id;
        

        $result = $connInvoice->selectRaw('SUM(sub_total) as total')->first();
        $totalRP = number_format($result->total, 0, ',', '.');
        $data['invoiceTotalRP'] = "Rp. " . $totalRP;

        $result = $connInvoice
            ->where('transaction_status', '=', 'paid')
            ->selectRaw('SUM(sub_total) as total')
            ->first();

        $totalRP = number_format($result->total, 0, ',', '.');
        $data['PaidInvoiceTotalRP'] = "Rp " . $totalRP;

        $resultCancel = $connInvoice
            ->where('transaction_status', '=', 'cancelled')
            ->selectRaw('SUM(sub_total) as total')
            ->first();

        $totalRP = number_format($resultCancel->total, 0, ',', '.');
        $data['CancelInvoiceTotalRP'] = "Rp " . $totalRP;


        $data['entry_ticket'] = $connTicket->count();
        $data['invoice'] = $connInvoice->count();
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
        $data['idusers'] = Login::where('id', $user_id)->get();

        $data['complete_paid'] = $connInvoice->where('transaction_status', 'paid')->count();
        $data['cancel_paid'] = $connInvoice->where('transaction_status', 'cancelled')->count();
        $data['complete_paid'] = $connInvoice->where('transaction_status', 'paid')->count();

        $data['complete_ticket'] = $connTicket->where('status_request', 'complete')->count();
        $data['hold_ticket'] = $connTicket->where('status_request', 'pending')->count();
        $data['cancel_ticket'] = $connTicket->where('status_request', 'rejected')->count();
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

    public function notDoneRequest()
    {
        $connTickets = ConnectionDB::setConnection(new OpenTicket());

        $notifications = $connTickets->where('status_request', '!=', 'COMPLETE')
            ->count();

        return response()->json($notifications);
    }

    public function notDoneWR()
    {
        $connWR = ConnectionDB::setConnection(new WorkRequest());

        $notifications = $connWR->where('status_request', '!=', 'COMPLETE')
            ->count();

        return response()->json($notifications);
    }

    public function notDoneWO()
    {
        $connWO = ConnectionDB::setConnection(new WorkOrder());

        $notifications = $connWO->where('status_wo', '!=', 'COMPLETE')
            ->count();

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
            case ('TApproveWorkOrder'):
                $data = $this->handleWO($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.WorkOrder', $data);
                break;

            case ('MApproveWorkOrder'):
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

            case ('SplitMonthlyTenant'):
                $data = $this->handleSplitMonthlyTenant($getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.Invoice.SplitPaymentMonthly.SplitPayment', $data);
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

            case ('paymentPermit'):
                $data = $this->handleWPPayment($connApprove, $getNotif);
                $data['user'] = $user;
                return view('Tenant.Notification.WorkPermitPayment', $data);
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

            case ('IzinKerja'):
                $data = $this->handleIzinKerja($getNotif);
                return view('AdminSite.WorkPermit.printout', $data);
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

            case ('UURElectric'):
                return redirect()->route('usr-electric');
                break;

            case ('UURWater'):
                return redirect()->route('uus-water');
                break;

            case ('Reminder'):
                return redirect()->route('reminders.show', $getNotif->id_data);
                break;

            case ('Installment'):
                return redirect()->route('showInvoices', $getNotif->id_data);
                break;

            case ('SP'):
                $data = $this->handleSP($getNotif->id_data);
                $data['data'] = $data;
                $data['notif'] = $getNotif;
                return view('AdminSite.SP1.SP1', $data);
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
        $connUtility = ConnectionDB::setConnection(new Utility());
        $connIPLType = ConnectionDB::setConnection(new IPLType());
        $getData = ConnectionDB::setConnection($model);
        $getData = $getData->find($getNotif->id_data);
        $data['transaction'] = $getData->where('id_monthly_ar_tenant', $getData->id_monthly_ar_tenant)->first();
        $data['type'] = 'MonthlyTenant';
        $data['installment'] = $getData->CashReceipt->Installment($getData->periode_bulan, $getData->periode_tahun);
        $data['electric'] = $connUtility->find(1);
        $data['water'] = $connUtility->find(2);
        $data['sc'] = $connIPLType->find(6);
        $data['sf'] = $connIPLType->find(7);

        return $data;
    }

    public function handleSplitMonthlyTenant($getNotif)
    {
        $model = new MonthlyArTenant();
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $getData = ConnectionDB::setConnection($model);
        $getData = $getData->find($getNotif->id_data);

        $data['transaction'] = $getData->where('id_monthly_ar_tenant', $getData->id_monthly_ar_tenant)->first();
        $data['setting'] = $connSetting->find(1);
        // $data['installment'] = $getData->CashReceipt->Installment($getData->periode_bulan, $getData->periode_tahun)

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

    public function handleWPPayment($connApprove, $getNotif)
    {
        $model = new CashReceipt();
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $getData = ConnectionDB::setConnection($model);
        $getData = $getData->find($getNotif->id_data);
        $data['transaction'] = $getData->where('id', $getData->id)->first();
        $data['type'] = 'wp';
        $data['setting'] = $connSetting->find(1);

        return $data;
    }

    public function handleIzinKerja($getNotif)
    {
        $model = new WorkPermit();
        $modelSetting = new CompanySetting();

        $getData = ConnectionDB::setConnection($model);
        $connSetting = ConnectionDB::setConnection($modelSetting);

        $permit =  $getData->find($getNotif->id_data);
        $setting =  $connSetting->find(1);

        $data['wp'] = $permit;
        $data['setting'] = $setting;

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
        $model = new CashReceipt();
        $getData = ConnectionDB::setConnection($model);
        $rsv =  $getData->find($getNotif->id_data);
        $data['reservation'] = $rsv->Reservation;
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

    public function handleSP($id)
    {
        $connCompany = ConnectionDB::setConnection(new CompanySetting());
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());
        $connDenda = ConnectionDB::setConnection(new JenisDenda());
        $connReminder = ConnectionDB::setConnection(new ReminderLetter());

        $data['company'] = $connCompany->find(1);
        $data['ar'] = $connAR->find($id);
        $data['denda'] = $connDenda->where('is_active', 1)->first();
        $data['reminders'] = $connReminder->get();

        return $data;
    }
}
