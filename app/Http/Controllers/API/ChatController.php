<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\RoomChat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function listRoomChat(Request $request)
    {
        $connRC = ConnectionDB::setConnection(new RoomChat());
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();

        $rc = $connRC->where('receiver_id', $user->id_user)
            ->orWhere('sender_id', $user->id_user)
            ->with(['Chats' => function($q) {
                $q->orderBy('created_at', 'desc')->first();
            }])
            ->get();

        return ResponseFormatter::success($rc, 'Success get all room chats');
    }

    public function showRoomChat($id)
    {
        $connRC = ConnectionDB::setConnection(new RoomChat());

        $rc = $connRC->where('id', $id)
            ->with(['Chats' => function($q) {
                $q->with(['Sender', 'Receiver']);
            }])
            ->first();

        return ResponseFormatter::success($rc, 'Success show room chat');
    }
}
