<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
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

        if ($reservation->is_deposit) {
            $object->total = $reservation->CashReceipt->sub_total;
        }

        return ResponseFormatter::success(
            $object,
            'Success get reservation'
        );
    }
}
