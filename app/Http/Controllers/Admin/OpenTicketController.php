<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\ApproveRequest;
use App\Models\Divisi;
use App\Models\JenisRequest;
use App\Models\Login;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\RequestGIGO;
use App\Models\Site;
use App\Models\System;
use App\Models\Tenant;
use App\Models\OwnerH;
use App\Models\TenantUnit;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkPriority;
use App\Models\WorkRelation;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class OpenTicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('user');

        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connUser = ConnectionDB::setConnection(new User());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        if ($user->user_category == 3) {
            $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
            $data['tickets'] = $connRequest->where('id_tenant', $tenant->id_tenant)->latest()->get();
        } else {
            $data['tickets'] = $connRequest->get();
        }
        $data['user'] = $user;

        return view('AdminSite.OpenTicket.index', $data);
    }

    public function create(Request $request)
    {
        $user = $request->session()->get('user');
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connTU = ConnectionDB::setConnection(new TenantUnit());
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());

        if ($user->user_category == 3) {
            $data['units'] = $connTU->get();
            $data['tenants'] = $connTenant->get();
        } else {

            $data['units'] = $connTU->get();
            $data['tenants'] = $connTenant->get();
        }

        $data['user'] = $user;
        $data['jenis_requests'] = $connJenisReq->get();

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

            $createTicket->save();
            $system->sequence_notiket = $count;
            $system->save();

            DB::commit();

            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $createTicket->no_tiket,
                'message' => $createTicket->no_tiket,
                'id_data' => $createTicket->id,
                'sender' => $tenant->User->id_user,
                'division_receiver' => $receiver->id_work_relation,
                'notif_message' => 'Tiket sudah dibuat, mohon proses request saya',
                'receiver' => null,
            ];

            broadcast(new HelloEvent($dataNotif));

            Alert::success('Berhasil', 'Berhasil menambahkan request');

            return redirect()->route('open-tickets.index');
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

        $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
        $user = $request->session()->get('user');

        $data['jenis_requests'] = $connJenisReq->get();
        $data['ticket'] = $ticket;
        $data['user'] = $user;
        $data['Tenant'] = $connTenant->get();
        $data['Owner'] = $connOwner->get();

        if ($request->data_type == 'json') {
            return response()->json(['data' => $ticket]);
        } else {
            return view('AdminSite.OpenTicket.show', $data);
        }
    }

    public function update(Request $request, $id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connNotif = ConnectionDB::setConnection(new Notifikasi());
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();
            $ticket = $connRequest->find($id);
            $ticket->id_jenis_request = $request->id_jenis_request;
            $ticket->status_request = $request->status_request;
            if ($request->status_request == 'DONE') {
                $notif = $connNotif->where('models', 'OpenTicket')
                    ->where('is_read', 0)
                    ->where('id_data', $id)
                    ->first();

                if (!$notif) {
                    $createNotif = $connNotif;
                    $createNotif->sender = $user->id_user;
                    $createNotif->receiver = $ticket->Tenant->User->id_user;
                    $createNotif->is_read = 0;
                    $createNotif->models = 'OpenTicket';
                    $createNotif->id_data = $id;
                    $createNotif->notif_title = $ticket->no_tiket;
                    $createNotif->notif_message = 'Keluhan sudah dikerjakan, mohon periksa kembali pekerjaan kami';
                    $createNotif->save();
                }
            } elseif ($request->status_request == 'PROSES KE GIGO') {
                $this->createGIGO($connNotif, $user, $ticket);
            } elseif (!$request->status_request) {
                $ticket->status_request = 'RESPONDED';
            }
            $ticket->save();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal mengupdate tiket');

            return redirect()->back();
        }

        Alert::success('Berhasil', 'Berhasil mengupdate tiket');

        return redirect()->back();
    }

    public function createGIGO($connNotif, $user, $ticket)
    {
        $connSystem = ConnectionDB::setConnection(new System());
        $nowDate = Carbon::now();
        $system = $connSystem->find(1);
        $count = $system->sequence_no_gigo + 1;

        $no_gigo = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_gigo . '/' .
            Carbon::now()->format('m') . $nowDate->year . '/' .
            sprintf("%06d", $count);

        $createRG = ConnectionDB::setConnection(new RequestGIGO());
        $createRG->no_tiket = $ticket->no_tiket;
        $createRG->no_request_gigo = $no_gigo;

        $system->sequence_no_gigo = $count;

        $notif = $connNotif->where('models', 'GIGO')
            ->where('is_read', 0)
            ->where('id_data', $createRG->id)
            ->first();

        $createRG->save();

        if (!$notif) {
            $createNotif = $connNotif;
            $createNotif->sender = $user->id_user;
            $createNotif->receiver = $ticket->Tenant->User->id_user;
            $createNotif->is_read = 0;
            $createNotif->models = 'GIGO';
            $createNotif->id_data = $createRG->id;
            $createNotif->notif_title = $createRG->no_request_gigo;
            $createNotif->notif_message = 'Request GIGO disetujui, mohon mengisi formulir GIGO';
            $createNotif->save();
        }

        $system->save();
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

        return redirect()->back();
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
}
