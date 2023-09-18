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
        $connRG = ConnectionDB::setConnection(new RequestGIGO());
        $conn = ConnectionDB:setConnection(new )

        $data['gigo'] = $conn->where('id' , $id)->first();   

        return view('AdminSite.GIGO.show', $data);
    }

    public function show(Request $request, $id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $rp = $connRP->where('id', $id)->with(['tenant', 'ticket', 'rpdetail'])->first();

        $data['approve'] = $connApprove->find(5);
        $data['user'] = $request->session()->get('user');
        $data['work_relations'] = $connWorkRelation->get();

        if ($request->data_type == 'json') {
            $data['ticket'] = $rp;
            return response()->json(['data' => $rp]);
        } else {
            $wp = $connWP->find($id);
            $data['wp'] = $wp;
            $dataJSON = json_decode($wp->RequestPermit->RPDetail->data);
            $dataJSON = json_decode($dataJSON);
            $data['personels'] = $dataJSON->personels;
            $data['alats'] = $dataJSON->alats;
            $data['materials'] = $dataJSON->materials;

            return view('AdminSite.WorkPermit.show', $data);
        }
    }
}
