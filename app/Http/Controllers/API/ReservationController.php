<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\Reservation;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class ReservationController extends Controller
{
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
        $object->notes = strip_tags($reservation->keterangan);
        $object->notes_by = $reservation->Ticket->ResponseBy->nama_user;
        $object->status_reservation = $reservation->sign_approval_1 ? 'APPROVED' : 'PENDING';

        if ($reservation->is_deposit) {
            $object->total = $reservation->jumlah_deposit;
        }

        return ResponseFormatter::success(
            $object,
            'Success get reservation'
        );
    }

    public function approve($id)
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

    public function reject($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->Ticket->status_request = 'REJECTED';
        $rsv->Ticket->save();

        return ResponseFormatter::success(
            $rsv,
            'Success reject reservation'
        );
    }

    public function showBilling($id, Request $request)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $site = Site::find($request->user()->id_site);

        $rsv = $connReservation->find($id);

        $object = new stdClass();
        $object->reservation_id = $rsv->id;
        $object->transaction_id = $rsv->CashReceipt->id;
        $object->no_invoice = $rsv->CashReceipt->no_invoice;
        $object->issue_date = $rsv->CashReceipt->created_at;
        $object->due_date = $rsv->CashReceipt->created_at->addDays(1);
        $object->invoice_to = $rsv->Ticket->Tenant->nama_tenant;
        $object->site = $site->nama_site;
        $object->unit = $rsv->Ticket->Unit->nama_unit;
        $object->province = $site->provinsi;
        $object->postal_code = $site->kode_pos;
        $object->deposit = $rsv->jumlah_deposit;

        return ResponseFormatter::success(
            $object,
            'Success billing reservation'
        );
    }
}
