<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\JenisPekerjaan;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\RequestPermit;
use App\Models\RequestPermitDetail;
use App\Models\System;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\WorkRelation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class RequestPermitController extends Controller
{
    public function index(Request $request)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());

        $data['user'] = $request->session()->get('user');
        $data['permits'] = $connRP->latest()->get();

        return view('AdminSite.RequestPermit.index', $data);
    }

    public function create(Request $request)
    {
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connJenisPekerjaan = ConnectionDB::setConnection(new JenisPekerjaan());

        $data['id_tiket'] = $request->id_tiket;
        if($request->id_tiket) {
            $data['tiket'] = $connTicket->find($request->id_tiket);
        } else {
            $data['tiket'] = null;
        }
        $data['jenis_pekerjaan'] = $connJenisPekerjaan->get();
        $data['work_relations'] = $connWorkRelation->get();
        $data['tickets'] = $connTicket->where('status_request', 'PROSES KE PERMIT')->get();

        return view('AdminSite.RequestPermit.create', $data);
    }

    public function showRPTicket($id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $ticket = $connRequest->where('id', $id)->with(['Tenant', 'RequestPermit.RPDetail'])->first();
        return response()->json(['data' => $ticket]);
    }

    function createTicket($request)
    {
        $user = $request->session()->get('user');
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
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
            $system->sequence_notiket = $count;

            $system->save();
            $createTicket->save();

            DB::commit();

            return $createTicket;
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function store(Request $request)
    {
        $permit_detail = [];
        $permit_detail['personels'] = $request->personels;
        $permit_detail['alats'] = $request->alats;
        $permit_detail['materials'] = $request->materials;
        $permit_detail = json_encode($permit_detail);

        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connSystem = ConnectionDB::setConnection(new System());
        $connRPDetail = ConnectionDB::setConnection(new RequestPermitDetail());
        $tiket = $this->createTicket($request);

        $user = $request->session()->get('user');
        $system = $connSystem->find(1);
        $nowDate = Carbon::now();
        $count = $system->sequence_no_pr + 1;

        $no_tiket = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_pr . '/' .
            Carbon::now()->format('m') . $nowDate->year . '/' .
            sprintf("%06d", $count);

        try {
            DB::beginTransaction();

            $request_permit = $connRP->create([
                'id_site' => $user->id_site,
                'no_tiket' => $tiket->no_tiket,
                'id_jenis_pekerjaan' => $request->requestPermit['id_jenis_pekerjaan'],
                'keterangan_pekerjaan' => $request->requestPermit['keterangan_pekerjaan'],
                'status_request' => 'PENDING',
                'id_tenant' => $tiket->id_tenant,
                'no_request_permit' => $no_tiket,
                'nama_kontraktor' => $request->requestPermit['nama_kontraktor'],
                'pic' => $request->requestPermit['pic'],
                'alamat' => $request->requestPermit['alamat'],
                'no_ktp' => $request->requestPermit['no_ktp'],
                'no_telp' => $request->requestPermit['no_telp'],
                'tgl_mulai' => $request->requestPermit['tgl_mulai'],
                'tgl_akhir' => $request->requestPermit['tgl_akhir'],
            ]);

            $connRPDetail->create([
                'no_tiket' => $request_permit->no_tiket,
                'data' => json_encode($permit_detail)
            ]);

            $system->sequence_no_pr = $count;
            $system->save();

            DB::commit();

            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $tiket->no_tiket,
                'id_data' => $tiket->id,
                'sender' => $user->id_user,
                'division_receiver' => 1,
                'notif_message' => 'Request Permit berhasil dibuat, mohon proses request saya',
                'receiver' => null,
                'connection' => ConnectionDB::getDBname()
            ];

            broadcast(new HelloEvent($dataNotif));

            return response()->json(['status' => 'ok']);
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['status' => 'fail']);
        }
    }

    public function show($id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());

        $rp = $connRP->find($id);
        $data['rp'] = $rp;
        $dataJSON = json_decode($rp->RPDetail->data);
        $dataJSON = json_decode($dataJSON);
        $data['personels'] = $dataJSON->personels;
        $data['alats'] = $dataJSON->alats;
        $data['materials'] = $dataJSON->materials;

        return view('AdminSite.RequestPermit.show', $data);
    }

    public function approveRP1(Request $request, $id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());

        $rp = $connRP->find($id);
        $rp->status_request = 'APPROVED';
        $rp->sign_approval_1 = Carbon::now();
        $rp->save();

        $dataNotif = [
            'models' => 'RequestPermit',
            'notif_title' => $rp->no_request_permit,
            'id_data' => $rp->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => 1,
            'notif_message' => 'Request Permit disetujui, mohon diproses lebih lanjut..',
            'receiver' => null,
            'connection' => ConnectionDB::getDBname()
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function rejectRP(Request $request, $id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());

        $rp = $connRP->find($id);

        $rp->status_request = 'REJECTED';
        $rp->save();

        $rp->Ticket->status_request = 'REJECTED';
        $rp->Ticket->save();

        $dataNotif = [
            'models' => 'RequestPermit',
            'notif_title' => $rp->no_request_permit,
            'id_data' => $rp->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => 1,
            'notif_message' => 'Maaf request permit saya tolak, terima kasih..',
            'receiver' => null,
            'connection' => ConnectionDB::getDBname()
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }
}
