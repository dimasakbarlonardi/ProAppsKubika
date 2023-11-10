<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\JenisPekerjaan;
use App\Models\OpenTicket;
use App\Models\RequestPermit;
use App\Models\RequestPermitDetail;
use App\Models\System;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class RequestPermitController extends Controller
{
    public function show($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->where('id', $id)->with('RequestPermit')->first();

        $object = new stdClass();
        $object->id = $wp->id;
        $object->deposit = (int) $wp->jumlah_deposit;
        $object->supervisi = (int) $wp->jumlah_supervisi;
        $object->description_permit = $wp->RequestPermit->keterangan_pekerjaan;
        $object->no_request = $wp->Ticket->no_tiket;
        $object->no_request = $wp->Ticket->no_tiket;
        $object->request_title = $wp->Ticket->judul_request;
        $object->request_type = 'Permit';
        $object->request_date = $wp->Ticket->created_at;
        $object->unit = $wp->Ticket->Unit->nama_unit;
        $object->tenant = $wp->Ticket->Tenant->nama_tenant;
        $object->permit_number = $wp->no_work_permit;
        $object->permit_type = $wp->RequestPermit->JenisPekerjaan->jenis_pekerjaan;
        $object->work_start = $wp->RequestPermit->tgl_mulai;
        $object->work_end = $wp->RequestPermit->tgl_akhir;
        $object->kontraktor_name = $wp->RequestPermit->nama_kontraktor;
        $object->kontraktor_id = $wp->RequestPermit->no_ktp;
        $object->kontraktor_phone = $wp->RequestPermit->no_telp;
        $object->kontraktor_address = $wp->RequestPermit->alamat;

        $dataJSON = json_decode($wp->RequestPermit->RPDetail->data);
        $dataJSON = json_decode($dataJSON);
        $data['personels'] = $dataJSON->personels;
        $data['alats'] = $dataJSON->alats;
        $data['materials'] = $dataJSON->materials;

        $object->personels =  $data['personels'];
        $object->alats =  $data['alats'];
        $object->materials =  $data['materials'];

        return ResponseFormatter::success(
            $object,
            'Success get Work Permit'
        );
    }

    public function jenisPekerjaan()
    {
        $connJenisPerkejaan = ConnectionDB::setConnection(new JenisPekerjaan());

        $data = $connJenisPerkejaan->get();

        return ResponseFormatter::success(
            $data,
            'Success get work types'
        );
    }

    function createTicket($request)
    {
        $user = $request->user();
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $tenant = $connTenant->where('email_tenant', $user->email)->first();
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
            $createTicket->id_jenis_request = 2;
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
        $permit_detail['personels'] = json_decode($request->personels);
        $permit_detail['alats'] = json_decode($request->alats);
        $permit_detail['materials'] = json_decode($request->materials);

        $permit_detail = json_encode($permit_detail);

        $connRP = ConnectionDB::setConnection(new RequestPermit());
        $connSystem = ConnectionDB::setConnection(new System());
        $connRPDetail = ConnectionDB::setConnection(new RequestPermitDetail());
        $tiket = $this->createTicket($request);

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
                'id_site' => $tiket->Tenant->User->id_site,
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

            $system->sequence_no_pr = $count;
            $system->save();

            DB::commit();

            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $tiket->no_tiket,
                'id_data' => $tiket->id,
                'sender' => $tiket->Tenant->User->id_user,
                'division_receiver' => 1,
                'notif_message' => 'Request Permit berhasil dibuat, mohon proses request saya',
                'receiver' => null
            ];

            broadcast(new HelloEvent($dataNotif));

            return ResponseFormatter::success(
                $request_permit,
                'Success create permit'
            );
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['status' => 'fail']);
        }
    }

    public function accept($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);

        $wp->status_request = 'APPROVED';
        $wp->sign_approval_1 = Carbon::now();
        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $wp->Ticket->Tenant->User->id_user,
            'division_receiver' => $wp->id_work_relation,
            'notif_message' => 'Work Permit diterima, mohon diproses lebih lanjut. Terima kasih..',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wp,
            'Success approve permit'
        );
    }

    public function approve2($id)
    {
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connUser = ConnectionDB::setConnection(new User());
        $request = Request();

        $wp = $connWP->find($id);
        $wp->sign_approval_2 = Carbon::now();
        $approve = $connApprove->find(5);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $user->id_user,
            'division_receiver' => null,
            'notif_message' => 'Work Permit diterima, mohon diproses lebih lanjut',
            'receiver' => $approve->approval_3,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $wp,
            'Success approve permit'
        );
    }

    public function approve4($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connUser = ConnectionDB::setConnection(new User());

        $request = Request();
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $wp = $connWP->find($id);

        $wp->sign_approval_4 = Carbon::now();
        $wp->generateBarcode();
        $wp->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $id,
            'sender' => $user->id_user,
            'division_receiver' => $wp->id_work_relation,
            'notif_message' => 'Work Permit diterima, selamat bekerja',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        $dataNotifIzinKerja = [
            'models' => 'IzinKerja',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $wp->id,
            'sender' => $user->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Work Permit diterima, berikut surat izin kerja permit',
            'receiver' => $wp->Ticket->Tenant->User->id_user
        ];

        broadcast(new HelloEvent($dataNotifIzinKerja));

        return ResponseFormatter::success(
            $wp,
            'Success approve permit'
        );
    }

    public function done($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());
        $connUser = ConnectionDB::setConnection(new User());

        $request = Request();

        $user = $connUser->where('login_user', $request->user()->email)->first();
        $wp = $connWP->find($id);

        $wp->status_request = 'DONE';
        $wp->save();
        $wp->RequestPermit->status_request = 'DONE';
        $wp->RequestPermit->save();
        $wp->Ticket->status_request = 'DONE';
        $wp->Ticket->save();

        $dataNotif = [
            'models' => 'WorkPermit',
            'notif_title' => $wp->no_work_permit,
            'id_data' => $id,
            'sender' => $user->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Work Permit telah selesai, terima kasih.',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return response()->json(['status' => 'ok']);
    }

    public function doneDeposit($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);

        $bapp = $wp->BAPP;
        $bapp->sign_approval_1 = Carbon::now();
        $bapp->save();
        $bapp->RequestPermit->status_request = 'DONE';
        $bapp->RequestPermit->save();
        $bapp->Ticket->status_request = 'DONE';
        $bapp->Ticket->save();

        $dataNotif = [
            'models' => 'BAPP',
            'notif_title' => $bapp->no_bapp,
            'id_data' => $bapp->id,
            'sender' => $wp->Ticket->Tenant->User->id_user,
            'division_receiver' => 6,
            'notif_message' => 'Deposit sudah kembali, terima kasih.',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        $dataNotifBM = [
            'models' => 'BAPP',
            'notif_title' => $bapp->no_bapp,
            'id_data' => $bapp->id,
            'sender' => $wp->Ticket->Tenant->User->id_user,
            'division_receiver' => 2,
            'notif_message' => 'Deposit sudah kembali, terima kasih.',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotifBM));

        return response()->json(['status' => 'ok']);
    }

    public function complete($id)
    {
        $connWP = ConnectionDB::setConnection(new WorkPermit());

        $wp = $connWP->find($id);
        $wp->status_request = 'COMPLETE';
        $wp->save();
        $wp->RequestPermit->status_request = 'COMPLETE';
        $wp->RequestPermit->save();
        $wp->Ticket->status_request = 'COMPLETE';
        $wp->Ticket->save();

        return response()->json(['status' => 'ok']);
    }
}
