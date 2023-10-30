<?php

namespace App\Http\Controllers\Admin;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\DetailGIGO;
use App\Models\RequestGIGO;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            'division_receiver' => null,
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

        Alert::success('Berhasil', 'Berhasil approve GIGO');

        return redirect()->back();
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

    public function show(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new RequestGIGO());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['gigo'] = $conn->where('id', $id)->first();
        $data['approve'] = $connApprove->find(8);
        $data['user'] = $request->session()->get('user');

        return view('AdminSite.GIGO.show', $data);
    }
}
