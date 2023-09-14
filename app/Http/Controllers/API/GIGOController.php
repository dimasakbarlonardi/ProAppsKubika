<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\DetailGIGO;
use App\Models\RequestGIGO;
use Illuminate\Http\Request;

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

        return ResponseFormatter::success([
            $gigo
      ], 'Berhasil submit GIGO');
    }
}
