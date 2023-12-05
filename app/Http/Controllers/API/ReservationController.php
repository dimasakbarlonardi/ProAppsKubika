<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\OpenTicket;
use App\Models\Reservation;
use App\Models\RuangReservation;
use App\Models\Site;
use App\Models\System;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JenisAcara;
use stdClass;

class ReservationController extends Controller
{
    public function JenisAcara()
    {
        $connJenisAcara = ConnectionDB::setConnection(new JenisAcara());

        $data = $connJenisAcara->get();

        return ResponseFormatter::success(
            $data,
            'Success get reservation type'
        );
    }
    public function RoomRSV()
    {
        $connRuangRsv = ConnectionDB::setConnection(new RuangReservation());

        $data = $connRuangRsv->get();

        return ResponseFormatter::success(
            $data,
            'Success get reservation rooms'
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
            $createTicket->id_jenis_request = 4;
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
        $ticket = $this->createTicket($request);

        $connUser = ConnectionDB::setConnection(new User());
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connSystem = ConnectionDB::setConnection(new System());
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $waktu_mulai = $request->tanggal_request_reservation . ' ' . $request->waktu_mulai;
        $waktu_akhir = $request->tanggal_request_reservation . ' ' . $request->waktu_akhir;

        try {
            DB::beginTransaction();

            $system = $connSystem->find(1);
            $count = $system->sequence_no_reservation + 1;

            $no_reservation = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_reservation . '/' .
                Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
                sprintf("%06d", $count);

            $rsv = $connReservation->create([
                'no_tiket' => $ticket->no_tiket,
                'no_request_reservation' => $no_reservation,
                'tgl_request_reservation' => $request->tanggal_request_reservation,
                'id_ruang_reservation' => $request->id_ruang_reservation,
                'id_jenis_acara' => $request->id_jenis_acara,
                'keterangan' => $request->keterangan,
                'durasi_acara' => $request->durasi_acara . ' Jam',
                'waktu_mulai' => $waktu_mulai,
                'waktu_akhir' => $waktu_akhir,
                'status_bayar' => 'PENDING',
            ]);

            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $ticket->no_tiket,
                'id_data' => $ticket->id,
                'sender' => $user->id_user,
                'division_receiver' => 1,
                'notif_message' => 'Request reservation sudah dibuat, mohon proses request saya',
                'receiver' => null,
            ];

            broadcast(new HelloEvent($dataNotif));

            $system->sequence_no_reservation = $count;
            $system->save();

            DB::commit();

            return ResponseFormatter::success(
                $rsv,
                'Success get reservation rooms'
            );
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }
    }

    public function index()
    {
        $connReqRev = ConnectionDB::setConnection(new Reservation());

        $reservations = $connReqRev->get();

        return ResponseFormatter::success(
            $reservations,
            'Get success all reservations'
        );
    }

    public function show($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $reservation = $connReservation->find($id);

        $object = new stdClass();
        $object->id = $reservation->id;
        $object->request_number = $reservation->no_tiket;
        $object->request_date = $reservation->tgl_request_reservation;
        $object->tenant = $reservation->Ticket->Tenant->nama_tenant;
        $object->request_title = $reservation->Ticket->judul_request;
        $object->request_type = 'Reservation';
        $object->reservation_number = $reservation->no_request_reservation;
        $object->reservation_type = $reservation->is_deposit ? 'Payable' : 'Free';
        $object->start_date = $reservation->waktu_mulai;
        $object->end_date = $reservation->waktu_akhir;
        $object->event_duration = $reservation->durasi_acara;
        $object->reservation_room = $reservation->RuangReservation->ruang_reservation;
        $object->jenis_acara = $reservation->JenisAcara->jenis_acara;
        $object->notes_by_tenant = strip_tags($reservation->keterangan);
        $object->resp_from_tr = strip_tags($reservation->Ticket->deskripsi_respon);
        $object->tr_name = $reservation->Ticket->ResponseBy ? $reservation->Ticket->ResponseBy->nama_user : null;
        $object->status_reservation = $reservation->sign_approval_1 ? 'APPROVED' : 'PENDING';
        $object->approve_1_tenant = $reservation->sign_approval_1;
        $object->approve_2_security = $reservation->sign_approval_2;
        $object->is_deposit = $reservation->is_deposit ? $reservation->is_deposit : 0;
        $object->jumlah_deposit = $reservation->jumlah_deposit;

        return ResponseFormatter::success(
            $object,
            'Success get reservation'
        );
    }

    public function approve1($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $approve = $connApprove->find(7);
        $rsv = $connReservation->find($id);

        $rsv->sign_approval_1 = Carbon::now();
        $rsv->save();

        $dataNotif = [
            'models' => 'Reservation',
            'notif_title' => $rsv->no_request_reservation,
            'id_data' => $rsv->id,
            'sender' => $rsv->Ticket->Tenant->User->id_user,
            'division_receiver' => $approve->approval_2,
            'notif_message' => 'Request Reservation diterima, mohon approve reservasi',
            'receiver' => null,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $rsv,
            'Success approve reservation'
        );
    }

    public function approve2($id, Request $request)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connApprove = ConnectionDB::setConnection(new Approve());
        $connUser = ConnectionDB::setConnection(new User());

        $approve = $connApprove->find(7);
        $rsv = $connReservation->find($id);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $rsv->sign_approval_2 = Carbon::now();
        $rsv->save();

        $dataNotif = [
            'models' => 'Reservation',
            'notif_title' => $rsv->no_request_reservation,
            'id_data' => $rsv->id,
            'sender' => $user->id_user,
            'division_receiver' => 6,
            'notif_message' => 'Request Reservation diterima, mohon approve reservasi',
            'receiver' => $approve->approval_3,
        ];

        broadcast(new HelloEvent($dataNotif));

        return ResponseFormatter::success(
            $rsv,
            'Success approve reservation'
        );
    }
}
