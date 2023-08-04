<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\OpenTicket;
use Illuminate\Http\Request;

class MainFormController extends Controller
{
    public function index(Request $request)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $data['tickets'] = $connRequest->latest()->get();

        if ($request->input) {
            $data = $connRequest->where("no_tiket", "like", "%". $request->input  . "%")->get();
            return response()->json([
                'html' => view('layouts.side-navigation')->render(),
            ]);
            return response()->json(['data' => $data]);
        } else {
            return view('AdminSite.TrackingTicket.index', $data);
        }
    }

    public function show(Request $request,$id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
        $user = $request->session()->get('user');

        $data['ticket'] = $ticket;
        $data['user'] = $user;

        return view('AdminSite.TrackingTicket.show', $data);
    }
}
