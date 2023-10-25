<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

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

        return ResponseFormatter::success(
            $reservation,
            'Success get reservation'
        );
    }
}
