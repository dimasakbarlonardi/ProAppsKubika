<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    function user()
    {
        $login = Auth::user();
        $userConn = ConnectionDB::setConnection(new User());

        $user = $userConn->where('login_user', $login->email)->first();

        return $user;
    }

    public function index()
    {
        $user = $this->user();

        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $notif = $connNotif->where('receiver', $user->id_user)
        ->orderBy('created_at', 'DESC')
        ->get();

        return ResponseFormatter::success(
            $notif,
            'Success get notifications'
        );
    }
}
