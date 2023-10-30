<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\DetailGIGO;
use App\Models\RequestGIGO;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GIGOController extends Controller
{
    public function show($id)
    {
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connGIGO->where('id', $id)
        ->with(['Ticket.Tenant', 'DetailGIGO'])
        ->first();

        return ResponseFormatter::success([
            $gigo
      ], 'Berhasil mengambil request');
    }

    public function addGood(Request $request, $id)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $data = $connDetailGIGO->create([
            'id_request_gigo' => $id,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'keterangan' => $request->keterangan,
        ]);

        return ResponseFormatter::success([
            $data
      ], 'Berhasil mengambil request');
    }

    public function removeGood(Request $request)
    {
        $connDetailGIGO = ConnectionDB::setConnection(new DetailGIGO());

        $connDetailGIGO->find($request->id)->delete();

        return response()->json(['status' => 'ok']);
    }

    public function update(Request $request, $id)
    {
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connGIGO->find($id);
        $gigo->update($request->all());

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $gigo->no_request_gigo,
            'id_data' => $gigo->id,
            'sender' => $gigo->Ticket->Tenant->User->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Form GIGO sudah dilengkapi, terima kasih',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success([
            $gigo
      ], 'Berhasil submit GIGO');
    }

    public function approve2($id)
    {
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());

        $gigo = $connGIGO->find($id);
        $gigo->sign_approval_1(Carbon::now());
        $gigo->save();

        return ResponseFormatter::success([
            $gigo
      ], 'Success approve 2 GIGO');
    }
}
