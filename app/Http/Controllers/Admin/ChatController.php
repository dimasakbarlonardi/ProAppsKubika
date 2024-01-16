<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatEvent;
use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\RoomChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connRoomChat = ConnectionDB::setConnection(new RoomChat());

        $user = $connUser->where('login_user', $request->user()->email)->first();
        $role = $user->RoleH->work_relation_id;

        if ($role == 1) {
            $data['rooms'] = $connRoomChat->orderBy('updated_at', 'DESC')->get();
        } else {
            $data['room'] = $connRoomChat->where('sender_id', $request->session()->get('user_id'))->first();
        }

        return view('AdminSite.Chat.index', $data);
    }

    public function rooms()
    {
        $connRoomChat = ConnectionDB::setConnection(new RoomChat());

        $data['rooms'] = $connRoomChat->orderBy('updated_at', 'DESC')
            ->with('Ticket')
            ->get();

        return response()->json([
            'html' => view('AdminSite.Chat.rooms', $data)->render()
        ]);
    }

    public function store(Request $request)
    {
        $connChat = ConnectionDB::setConnection(new Chat());
        $connUser = ConnectionDB::setConnection(new User());
        $connRoomChat = ConnectionDB::setConnection(new RoomChat());

        $sender = $connUser->where('login_user', $request->user()->email)->first();

        $isExist = $connRoomChat->find($request->room_id);

        if (!$isExist) {
            $connRoomChat->id = $request->room_id;
            $connRoomChat->receiver_id = $request->receiver_id;
            $connRoomChat->sender_id = $request->sender_id_value;
            $connRoomChat->save();
        }

        $connChat->room_id = $isExist ? $request->room_id : $connRoomChat->id;
        $connChat->message = $request->value;
        $connChat->receiver_id = $request->receiver_id;
        $connChat->sender_id = $sender->id_user;
        $connChat->is_read = false;
        $connChat->save();

        if ($isExist) {
            $isExist->updated_at = Carbon::now();
            $isExist->save();
        }

        $this->sendNotif($connChat, true);
    }

    public function getChats(Request $request)
    {
        $connRoom = ConnectionDB::setConnection(new RoomChat());

        $data['room'] = $connRoom->find($request->room_id);

        return response()->json([
            'html' => view('AdminSite.Chat.chat-room', $data)->render()
        ]);
    }

    public function roomSlave(Request $request, $id)
    {
        $connRoom = ConnectionDB::setConnection(new RoomChat());
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', $request->user()->email)->first();

        $data['room'] = $connRoom->where('sender_id', $user->id_user)
            ->where('id', $id)
            ->first();

        return response()->json([
            'html' => view('AdminSite.Chat.chat-room-slave', $data)->render()
        ]);
    }

    public function roomMaster(Request $request)
    {
        $connRoom = ConnectionDB::setConnection(new RoomChat());

        $data['room'] = $connRoom->find($request->room_id);

        return response()->json([
            'html' => view('AdminSite.Chat.chat-room-master', $data)->render(),
            'chat' => $data['room']
        ]);
    }

    public function readChats(Request $request)
    {
        $connRoom = ConnectionDB::setConnection(new RoomChat());

        $room = $connRoom->find($request->room_id);

        foreach ($room->Chats as $chat) {
            $chat->is_read = true;
            $chat->save();
        }

        $this->sendNotif($chat, false);
    }

    public function sendNotif($chat, $sound)
    {
        $dataNotif = [
            'room' => $chat->room_id,
            'receiver' => $chat->receiver_id,
            'sender' => $chat->sender_id,
            'sound' => $sound,
        ];
        broadcast(new ChatEvent($dataNotif));
    }
}
