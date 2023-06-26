<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\JenisPekerjaan;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\RequestPermit;
use App\Models\RequestPermitDetail;
use App\Models\System;
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

    public function create()
    {
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connJenisPekerjaan = ConnectionDB::setConnection(new JenisPekerjaan());

        $data['jenis_pekerjaan'] = $connJenisPekerjaan->get();
        $data['work_relations'] = $connWorkRelation->get();
        $data['tickets'] = $connTicket->where('status_request', 'PROSES KE PERMIT')->get();

        return view('AdminSite.RequestPermit.create', $data);
    }

    public function store(Request $request)
    {
        $permit_detail = [];
        $permit_detail['personels'] = $request->personels;
        $permit_detail['alats'] = $request->alats;
        $permit_detail['materials'] = $request->materials;
        $permit_detail = json_encode($permit_detail);

        $connTiket = ConnectionDB::setConnection(new OpenTicket());
        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connSystem = ConnectionDB::setConnection(new System());
        $connRPDetail = ConnectionDB::setConnection(new RequestPermitDetail());

        $tiket = $connTiket->find($request->no_tiket);
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
                'id_jenis_pekerjaan' => $request->id_jenis_pekerjaan,
                'keterangan_pekerjaan' => $request->keterangan_pekerjaan,
                'status_request' => 'PENDING',
                'id_tenant' => $tiket->id_tenant,
                'no_request_permit' => $no_tiket,
                'nama_kontraktor' => $request->nama_kontraktor,
                'pic' => $request->pic,
                'alamat' => $request->alamat,
                'no_ktp' => $request->no_ktp,
                'no_telp' => $request->no_telp,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_akhir' => $request->tgl_akhir,
            ]);

            $connRPDetail->create([
                'no_tiket' => $request_permit->no_tiket,
                'data' => json_encode($permit_detail)
            ]);

            $tiket->status_request = 'PROSES';
            $tiket->save();

            $system->sequence_no_pr = $count;
            $system->save();

            DB::commit();

            $connNotif = ConnectionDB::setConnection(new Notifikasi());
            $checkNotif = $connNotif->where('models', 'RequestPermit')
                ->where('is_read', 0)
                ->where('id_data', $request_permit->id)
                ->first();

            if (!$checkNotif) {
                $connNotif->create([
                    'receiver' => $tiket->Tenant->User->id_user,
                    'sender' => $user->id_user,
                    'is_read' => 0,
                    'models' => 'RequestPermit',
                    'id_data' => $request_permit->id,
                    'notif_title' => $request_permit->no_request_permit,
                    'notif_message' => 'Request Permit berhasil dibuat, berikut rancangannya'
                ]);
            }

            return response()->json(['status' => 'ok']);
        } catch (Throwable $e) {
            DB::rollBack();
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

    public function approveRP1($id)
    {
        $connRP = ConnectionDB::setConnection(new RequestPermit());

        $rp = $connRP->find($id);
        $rp->status_request = 'APPROVED';
        $rp->sign_approval_1 = Carbon::now();
        $rp->save();

        Alert::success('Berjasil', 'Berhasil menerima Request Permit');

        return redirect()->back();
    }
}