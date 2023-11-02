<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\DetailGIGO;
use App\Models\OpenTicket;
use App\Models\RequestGIGO;
use App\Models\System;
use App\Models\Tenant;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class GIGOController extends Controller
{
    public function index(Request $request)
    {
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['user'] = $request->session()->get('user');
        $data['approve'] = $connApprove->find(8);
        $data['gigos'] = $connGIGO->get();

        return view('AdminSite.GIGO.index', $data);
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
        $connSystem = ConnectionDB::setConnection(new System());
        $createRG = ConnectionDB::setConnection(new RequestGIGO());
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $ticket = $this->createTicket($request);
        $nowDate = Carbon::now();
        $system = $connSystem->find(1);
        $count = $system->sequence_no_gigo + 1;

        $no_gigo = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_gigo . '/' .
            Carbon::now()->format('m') . $nowDate->year . '/' .
            sprintf("%06d", $count);

        $createRG->status_request = 'PENDING';
        $createRG->gigo_type = $request->gigo['gigoType'];
        $createRG->nama_pembawa = $request->gigo['namaPembawa'];
        $createRG->no_pol_pembawa = $request->gigo['noPolPembawa'];
        $createRG->date_request_gigo = $request->gigo['dateRequestGigo'];
        $createRG->no_tiket = $ticket->no_tiket;
        $createRG->no_request_gigo = $no_gigo;
        $createRG->save();

        $system->sequence_no_gigo = $count;
        $system->save();

        foreach ($request->goods as $good) {
            $connDetailGIGO->create([
                'id_request_gigo' => $createRG->id,
                'nama_barang' => $good['nama_barang'],
                'jumlah_barang' => $good['jumlah_barang'],
                'keterangan' => $good['keterangan'] ? $good['keterangan'] : '-',
            ]);
        }

        $dataNotif = [
            'models' => 'OpenTicket',
            'notif_title' => $ticket->no_tiket,
            'id_data' => $ticket->id,
            'sender' => $request->session()->get('user')->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Request GIGO sudah dibuat, mohon proses request saya',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function update(Request $request, $id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $approve = $connApprove->find(8);
        $gigo = $connGIGO->find($id);
        $gigo->update($request->all());

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $gigo->no_request_gigo,
            'id_data' => $gigo->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => $approve->approval_1,
            'notif_message' => 'Form GIGO sudah dilengkapi, terima kasih',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function addGood(Request $request)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $data = $connDetailGIGO->create([
            'id_request_gigo' => $request->id_request_gigo,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'keterangan' => $request->keterangan ? $request->keterangan : '-',
        ]);

        return response()->json(['data' => $data]);
    }

    public function removeGood(Request $request)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $connDetailGIGO->find($request->id)->delete();

        return response()->json(['status' => 'ok']);
    }

    public function gigoApprove1(Request $request, $id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $approve = $connApprove->find(8);
        $gigo = $connDetailGIGO->find($id);

        $gigo->update([
            'sign_approval_1' => Carbon::now(),
            'status_request' => 'APPROVED'
        ]);

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $gigo->no_request_gigo,
            'id_data' => $gigo->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => $approve->approval_2,
            'notif_message' => 'Form GIGO sudah diapprove, mohon di tindak lanjuti',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function gigoApprove2(Request $request, $id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connDetailGIGO->find($id);

        $gigo->update([
            'sign_approval_2' => Carbon::now()
        ]);

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $gigo->no_request_gigo,
            'id_data' => $gigo->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => 1,
            'notif_message' => 'GIGO disetujui, mohon melakukan kegiatan sesuai jadwal',
            'receiver' => $gigo->Ticket->Tenant->User->id_user,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function gigoDone(Request $request, $id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $approve = $connApprove->find(8);
        $gigo = $connDetailGIGO->find($id);

        $gigo->status_request = 'DONE';
        $gigo->save();
        $gigo->Ticket->status_request = 'DONE';
        $gigo->Ticket->save();

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $gigo->no_request_gigo,
            'id_data' => $gigo->id,
            'sender' => $request->session()->get('user_id'),
            'division_receiver' => null,
            'notif_message' => 'GIGO telah selesai, terima kasih',
            'receiver' => $approve->approval_3,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function gigoComplete($id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connDetailGIGO->find($id);

        $gigo->status_request = 'COMPLETE';
        $gigo->sign_approval_3 = Carbon::now();
        $gigo->save();
        $gigo->Ticket->status_request = 'COMPLETE';
        $gigo->Ticket->save();

        return response()->json(['status' => 'ok']);
    }

    public function show($id, Request $request)
    {
        $conn = ConnectionDB::setConnection(new RequestGIGO());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['gigo'] = $conn->where('id', $id)->first();
        $data['approve'] = $connApprove->find(8);
        $data['user'] = $request->session()->get('user');

        return view('AdminSite.GIGO.show', $data);
    }
}
