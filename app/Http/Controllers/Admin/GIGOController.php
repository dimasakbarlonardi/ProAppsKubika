<?php

namespace App\Http\Controllers\Admin;

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
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connGIGO->find($id);
        $gigo->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate tiket');

        return redirect()->back();
    }

    public function addGood(Request $request)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $data = $connDetailGIGO->create([
            'id_request_gigo' => $request->id_request_gigo,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['data' => $data]);
    }

    public function removeGood(Request $request)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $connDetailGIGO->find($request->id)->delete();

        return response()->json(['status' => 'ok']);
    }

    public function gigoApprove1($id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connDetailGIGO->find($id);

        $gigo->update([
            'sign_approval_1' => Carbon::now(),
            'status_request' => 'APPROVED'
        ]);

        Alert::success('Berhasil', 'Berhasil approve GIGO');

        return redirect()->back();
    }

    public function gigoApprove2($id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connDetailGIGO->find($id);

        $gigo->update([
            'sign_approval_2' => Carbon::now()
        ]);

        Alert::success('Berhasil', 'Berhasil approve GIGO');

        return redirect()->back();
    }

    public function gigoDone($id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connDetailGIGO->find($id);

        $gigo->status_request = 'DONE';
        $gigo->save();
        $gigo->Ticket->status_request = 'DONE';
        $gigo->Ticket->save();

        Alert::success('Berhasil', 'Berhasil approve GIGO');

        return redirect()->back();
    }

    public function gigoComplete($id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connDetailGIGO->find($id);

        $gigo->status_request = 'COMPLETE';
        $gigo->save();
        $gigo->Ticket->status_request = 'COMPLETE';
        $gigo->Ticket->save();

        Alert::success('Berhasil', 'Berhasil approve GIGO');

        return redirect()->back();
    }

    public function show($id)
    {
        $conn = ConnectionDB::setConnection(new RequestGIGO());

        $data['gigo'] = $conn->where('id', $id)->first();

        return view('AdminSite.GIGO.show', $data);
    }
}
