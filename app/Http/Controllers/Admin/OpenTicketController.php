<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\FCM as FcmNotification;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\Divisi;
use App\Models\JenisAcara;
use App\Models\JenisRequest;
use App\Models\Login;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\RequestGIGO;
use App\Models\Site;
use App\Models\System;
use App\Models\Tenant;
use App\Models\OwnerH;
use App\Models\RequestType;
use App\Models\RuangReservation;
use App\Models\TenantUnit;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkPriority;
use App\Models\WorkRelation;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class OpenTicketController extends Controller
{
    public function index(Request $request)
    {
        $connTypeReq = ConnectionDB::setConnection(new JenisRequest());
        $connWorkPrior = ConnectionDB::setConnection(new WorkPriority());

        $data['types'] = $connTypeReq->get();
        $data['priorities'] = $connWorkPrior->get();

        return view('AdminSite.OpenTicket.index', $data);
    }

    public function filteredData(Request $request)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $user = $request->session()->get('user');
        $connTenant = ConnectionDB::setConnection(new Tenant());

        if ($user->user_category == 3) {
            $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
            $tickets = $connRequest->where('id_tenant', $tenant->id_tenant)->latest();
        } else {
            $tickets = $connRequest->where('deleted_at', null);
        }

        if ($request->valueString) {
            $valueString = $request->valueString;
            $tickets = $tickets->where('judul_request', 'like', '%' . $valueString . '%')
                ->orWhereHas('Tenant', function ($q) use ($valueString) {
                    $q->where('nama_tenant', 'like', '%' . $valueString . '%');
                })->orWhere('no_tiket', 'like', '%' . $valueString . '%');
        }

        if ($request->type != 'all') {
            $tickets = $tickets->where('id_jenis_request', $request->type);
        }
        if ($request->status != 'all') {
            $tickets = $tickets->where('status_request', $request->status);
        }
        if ($request->priority != 'all') {
            $tickets = $tickets->where('priority', $request->priority);
        }

        $tickets = $tickets->orderBy('id', 'DESC');

        $data['tickets'] = $tickets->get();

        return response()->json([
            'html' => view('AdminSite.OpenTicket.table-data', $data)->render()
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->session()->get('user');
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connTU = ConnectionDB::setConnection(new TenantUnit());
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());
        $connRuangRsv = ConnectionDB::setConnection(new RuangReservation());
        $connJenisAcara = ConnectionDB::setConnection(new JenisAcara());

        if ($user->user_category == 3) {
            $data['units'] = $connTU->where('id_tenant', $user->Tenant->id_tenant)->get();
            $data['tenants'] = $connTenant->get();
        } else {
            $data['units'] = $connTU->get();
            $data['tenants'] = $connTenant->get();
        }

        $data['user'] = $user;
        $data['jenis_requests'] = $connJenisReq->get();
        $data['ruangRsv'] = $connRuangRsv->get();
        $data['jenisAcara'] = $connJenisAcara->get();

        return view('AdminSite.OpenTicket.create', $data);
    }

    public function store(Request $request)
    {
        $user = $request->session()->get('user');
        $connReceiver = ConnectionDB::setConnection(new WorkRelation());
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
        $receiver = $connReceiver->find(1);
        $system = $connSystem->find(1);
        $count = $system->sequence_notiket + 1;

        $nowDate = Carbon::now();

        try {
            DB::beginTransaction();
            $unit = $connUnit->find($request->id_unit);

            $no_tiket = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_tiket . '/' .
                Carbon::now()->format('m') . $nowDate->year . '/' .
                sprintf("%06d", $count);

            $createTicket = $connOpenTicket->create($request->all());
            $createTicket->id_site = $unit->id_site;
            $createTicket->id_tower = $unit->id_tower;
            $createTicket->id_unit = $request->id_unit;
            $createTicket->id_lantai = $unit->id_lantai;
            $createTicket->id_tenant = $tenant->id_tenant;
            $createTicket->no_tiket = $no_tiket;
            $createTicket->status_request = 'PENDING';

            $file = $request->file('upload_image');

            if ($file) {
                $fileName = $createTicket->id . '-' .   $file->getClientOriginalName();
                $file->move('uploads/image/ticket', $fileName);
                $createTicket->upload_image = $fileName;
            }

            $system->sequence_notiket = $count;

            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $createTicket->no_tiket,
                'id_data' => $createTicket->id,
                'sender' => $tenant->User->id_user,
                'division_receiver' => $receiver->id_work_relation,
                'notif_message' => 'Tiket sudah dibuat, mohon proses request saya',
                'receiver' => null,
            ];

            $system->save();
            $createTicket->save();

            broadcast(new HelloEvent($dataNotif));
            DB::commit();

            Alert::success('Success', 'Success create request');

            return redirect()->route('open-tickets.index')->with('success', 'Success create request');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Error', $e);

            return redirect()->route('open-tickets.create');
        }
    }

    public function show(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connPriority = ConnectionDB::setConnection(new WorkPriority());

        $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
        $user = $request->session()->get('user');

        $data['jenis_requests'] = $connJenisReq->get();
        $data['ticket'] = $ticket;
        $data['user'] = $user;
        $data['Tenant'] = $connTenant->get();
        $data['Owner'] = $connOwner->get();
        $data['work_priorities'] = $connPriority->get();

        if ($request->data_type == 'json') {
            return response()->json(['data' => $ticket]);
        } else {
            return view('AdminSite.OpenTicket.show', $data);
        }
    }

    public function update(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();
            $ticket = $connRequest->find($id);
            $ticket->id_jenis_request = $request->id_jenis_request;
            $ticket->status_request = $request->status_request;
            $ticket->priority = $request->priority;

            if ($request->status_request == 'DONE') {
                $dataNotif = [
                    'models' => 'OpenTicket',
                    'notif_title' => $ticket->no_tiket,
                    'id_data' => $ticket->id,
                    'sender' => $user->id_user,
                    'division_receiver' => null,
                    'notif_message' => 'Keluhan sudah dikerjakan, mohon periksa kembali pekerjaan kami',
                    'receiver' => $ticket->Tenant->User->id_user,
                ];

                broadcast(new HelloEvent($dataNotif));
            } elseif (!$request->status_request) {
                $ticket->status_request = 'RESPONDED';
            }

            $ticket->save();
            DB::commit();

            if ($request->status_request == 'PROSES KE WR') {
                return redirect()->route('work-requests.create', ['id_tiket' => $ticket->id]);
            }

            if ($request->status_request == 'PROSES KE PERMIT') {
                return redirect()->route('request-permits.create', ['id_tiket' => $ticket->id]);
            }

            if ($request->status_request == 'PROSES KE RESERVASI') {
                return redirect()->route('request-reservations.create', ['id_tiket' => $ticket->id]);
            }

            if ($request->status_request == 'PROSES KE GIGO') {
                $this->approveGIGO($ticket, $request);
                return redirect()->route('open-tickets.index');
            }

            Alert::success('Success', 'Success update request');

            return redirect()->route('open-tickets.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal mengupdate tiket');

            return redirect()->back();
        }
    }

    public function approveGIGO($ticket, $request)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());

        $approve = $connApprove->find(8);

        $ticket->RequestGIGO->status_request = 'APPROVED';
        $ticket->RequestGIGO->sign_approval_1 = Carbon::now();
        $ticket->RequestGIGO->save();

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $ticket->RequestGIGO->no_request_gigo,
            'id_data' => $ticket->RequestGIGO->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => $approve->approval_2,
            'notif_message' => 'Form GIGO sudah diapprove, mohon di tindak lanjuti',
            'receiver' => null,
        ];

        $this->FCM($dataNotif, $request);      

        broadcast(new HelloEvent($dataNotif));
    }

    public function updateRequestTicket(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $user = $request->session()->get('user');
        $ticket = $connRequest->find($id);
        $ticket->status_respon = 'Responded';
        $ticket->status_request = 'RESPONDED';
        $ticket->tgl_respon_tiket = Carbon::now()->format("Y-m-d");
        $ticket->jam_respon = Carbon::now()->format("H:i");
        $ticket->deskripsi_respon = $request->deskripsi_respon;
        $ticket->id_user_resp_request = $user->id_user;
        $ticket->save();

        Alert::success('Berhasil', 'Berhasil merespon tiket');

        return redirect()->route('open-tickets.show', $ticket->id);
    }

    public function ticketApprove1(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $connTktApprove = ConnectionDB::setConnection(new Approve());

        $tktApprove = $connTktApprove->find(1);

        $user = $request->session()->get('user');

        $ticket = $connRequest->find($id);
        $ticket->sign_approve_1 = 1;
        $ticket->date_approve_1 = Carbon::now();
        $ticket->save();

        $notif = $connNotif->where('models', 'OpenTicket')
            ->where('is_read', 0)
            ->where('id_data', $id)
            ->first();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $user->id_user;
            $createNotif->receiver = $tktApprove->approval_2;
            $createNotif->is_read = 0;
            $createNotif->models = 'OpenTicket';
            $createNotif->id_data = $id;
            $createNotif->notif_title = $ticket->no_tiket;
            $createNotif->notif_message = 'Keluhan sudah saya approve, mohon approve untuk menselesaikan Request';
            $createNotif->save();
        }

        Alert::success('Berhasil', 'Berhasil approve tiket');

        return redirect()->back();
    }

    public function ticketApprove2($id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $ticket = $connRequest->find($id);
        $ticket->sign_approve_2 = 1;
        $ticket->date_approve_2 = Carbon::now();
        $ticket->status_request = 'COMPLETE';
        $ticket->save();

        Alert::success('Berhasil', 'Berhasil approve tiket');

        return redirect()->back();
    }

    function FCM($dataNotif, $request)
    {
        $connUser = ConnectionDB::setConnection(new User());

        $work_relation = $dataNotif['division_receiver'];

        $users = $connUser->where('deleted_at', null)->whereHas('RoleH.WorkRelation', function ($q) use ($work_relation) {
            $q->where('work_relation_id', $work_relation);
        })->get('login_user');

        $sender = $connUser->find($request->session()->get('user_id'));

        $logins = Login::whereIn('email', $users)
            ->where('fcm_token', '!=', null)
            ->get(['name', 'fcm_token']);

        if ($dataNotif['division_receiver'] && $dataNotif['receiver']) {
            foreach ($logins as $login) {
                $mobile_notif = new FcmNotification();
                $mobile_notif->setPayload([
                    'title' => $sender->nama_user,
                    'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                    'token' => $login->fcm_token,
                ])->send();
            }

            $userReceiver = $connUser->where('id_user', $dataNotif['receiver'])->first();
            $loginReceiver = Login::where('email', $userReceiver->login_user)->first();

            $mobile_notif = new FcmNotification();
            $mobile_notif->setPayload([
                'title' => $sender->nama_user,
                'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                'token' => $loginReceiver->fcm_token,
            ])->send();
        } elseif ($dataNotif['division_receiver']) {                
            foreach ($logins as $login) {
                $mobile_notif = new FcmNotification();
                $mobile_notif->setPayload([
                    'title' => $sender->nama_user,
                    'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                    'token' => $login->fcm_token,
                ])->send();
            }
        } else {
            $userReceiver = $connUser->where('id_user', $dataNotif['receiver'])->first();
            $loginReceiver = Login::where('email', $userReceiver->login_user)->first();

            $mobile_notif = new FcmNotification();
            $mobile_notif->setPayload([
                'title' => $sender->nama_user,
                'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                'token' => $loginReceiver->fcm_token,
            ])->send();
        }
    }
}
