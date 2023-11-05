<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\DetailGIGO;
use App\Models\OpenTicket;
use App\Models\RequestGIGO;
use App\Models\System;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use App\Helpers\FCM as FcmNotification;

class GIGOController extends Controller
{
    function createTicket($request)
    {
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $user = $request->user();

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
            $createTicket->id_jenis_request = 5;
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
        $createRG->gigo_type = $request->gigo_type;
        $createRG->nama_pembawa = $request->nama_pembawa;
        $createRG->no_pol_pembawa = $request->no_pol_pembawa;
        $createRG->date_request_gigo = $request->date_request_gigo;
        $createRG->no_tiket = $ticket->no_tiket;
        $createRG->no_request_gigo = $no_gigo;
        $createRG->save();

        $system->sequence_no_gigo = $count;
        $system->save();

        foreach (json_decode($request->goods) as $good) {
            $connDetailGIGO->create([
                'id_request_gigo' => $createRG->id,
                'nama_barang' => $good->nama_barang,
                'jumlah_barang' => $good->jumlah_barang,
                'keterangan' => $good->keterangan ? $good->keterangan : '-',
            ]);
        }

        $dataNotif = [
            'models' => 'OpenTicket',
            'notif_title' => $ticket->no_tiket,
            'id_data' => $ticket->id,
            'sender' => $ticket->Tenant->User->id_user,
            'division_receiver' => 1,
            'notif_message' => 'Request GIGO sudah dibuat, mohon proses request saya',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success([
            $createRG
        ], 'Success create request GIGO');
    }

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

    public function approve2($id, Request $request)
    {
        $connGIGO = ConnectionDB::setConnection(new RequestGIGO());
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();

        $gigo = $connGIGO->find($id);
        $gigo->sign_approval_2 = Carbon::now();
        $gigo->save();

        $gigo->GenerateBarcode();

        $dataNotif = [
            'models' => 'GIGO',
            'notif_title' => $gigo->no_request_gigo,
            'id_data' => $gigo->id,
            'sender' => $user->id_user,
            'division_receiver' => 1,
            'notif_message' => 'GIGO disetujui, mohon melakukan kegiatan sesuai jadwal',
            'receiver' => $gigo->Ticket->Tenant->User->id_user,
        ];

        $this->FCM($dataNotif, $request);

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success([
            $gigo
        ], 'Success approve 2 GIGO');
    }

    public function done($id, $token)
    {
        $request = Request();
        $connDetailGIGO = ConnectionDB::setConnection(new RequestGIGO());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();

        $approve = $connApprove->find(8);

        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $gigo = $connDetailGIGO->find($id);

            $gigo->status_request = 'DONE';
            $gigo->save();
            $gigo->Ticket->status_request = 'DONE';
            $gigo->Ticket->save();

            $dataNotif = [
                'models' => 'GIGO',
                'notif_title' => $gigo->no_request_gigo,
                'id_data' => $gigo->id,
                'sender' => $user->id_user,
                'division_receiver' => 1,
                'notif_message' => 'GIGO telah selesai, terima kasih',
                'receiver' => $approve->approval_3,
            ];

            $this->FCM($dataNotif, $request);

            broadcast(new HelloEvent($dataNotif));

            return ResponseFormatter::success(
                $gigo,
                'Success done gigo'
            );
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    function FCM($dataNotif, $request)
    {
        $connUser = ConnectionDB::setConnection(new User());

        $work_relation = $dataNotif['division_receiver'];

        $users = $connUser->where('deleted_at', null)->whereHas('RoleH.WorkRelation', function ($q) use ($work_relation) {
            $q->where('work_relation_id', $work_relation);
        })->get('login_user');

        $sender = $connUser->where('login_user', $request->user()->email)->first();
       
        $logins = Login::whereIn('email', $users)
            ->where('fcm_token', '!=', null)
            ->get(['name', 'fcm_token']);

        if ($dataNotif['division_receiver'] && $dataNotif['receiver']) {
            foreach ($logins as $login) {
                $mobile_notif = new FcmNotification();
                $mobile_notif->setPayload([
                    'title' => $sender->nama_user,
                    'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                    'token' => $login->fcm_token,
                    ])->send();
                }
                
            $userReceiver = $connUser->where('id_user', $dataNotif['receiver'])->first();
            $loginReceiver = Login::where('email', $userReceiver->login_user)->first();
                
            $mobile_notif = new FcmNotification();
            $mobile_notif->setPayload([
                'title' => $sender->nama_user,
                'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                'token' => $loginReceiver->fcm_token,
            ])->send();
        } elseif ($dataNotif['division_receiver'] && !$dataNotif['receiver']) {         
            foreach ($logins as $login) {
                $mobile_notif = new FcmNotification();
                $mobile_notif->setPayload([
                    'title' => $sender->nama_user,
                    'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                    'token' => $login->fcm_token,
                ])->send();
            }
        } else {
            $userReceiver = $connUser->where('id_user', $dataNotif['receiver'])->first();
            $loginReceiver = Login::where('email', $userReceiver->login_user)->first();

            $mobile_notif = new FcmNotification();
            $mobile_notif->setPayload([
                'title' => $sender->nama_user,
                'body' => $dataNotif['notif_message']. ' '.  $dataNotif['notif_title'],
                'token' => $loginReceiver->fcm_token,
            ])->send();
        }
    }
}
