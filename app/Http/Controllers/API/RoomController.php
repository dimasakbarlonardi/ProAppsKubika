<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $connRoom = ConnectionDB::setConnection(new Room());

        $room = $connRoom->get();

        return ResponseFormatter::success(
            $room,
            'Success get all rooms'
        );
    }
}
