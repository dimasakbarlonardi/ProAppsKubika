<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\OpenTicket;
use App\Models\Tenant;
use Illuminate\Http\Request;

class MainFormController extends Controller
{
    public function index(Request $request)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());
        $connTenant = ConnectionDB::setConnection(new Tenant());


        $user = $request->session()->get('user');

        if ($user->user_category == 3) {
            $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
            $tickets = $connRequest->where('id_tenant', $tenant->id_tenant)->latest();
        } else {
            $tickets = $connRequest->where('deleted_at', null);
        }

        $data['tickets'] = $tickets->latest()->get();

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
