<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\OpenTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TrackingTicketController extends Controller
{
    public function index(Request $request)
    {
        try {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $data['tickets'] = $connRequest->latest()->get();

        if ($request->input) {
            $data = $connRequest->where("no_tiket", "like", "%". $request->input  . "%")->get();
            return response()->json([
                'html' => view('layouts.side-navigation')->render(),
            ]);
            return response()->json(['data' => $data]);
        } else {
            return ResponseFormatter::success([
                $data
            ], 'Berhasil');
        }
        } catch (Throwable $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal');
        }
    }

    public function show($id)
    {
        try {
            $connRequest = ConnectionDB::setConnection(new OpenTicket());
    
            $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
    
            $data['ticket'] = $ticket;

            return ResponseFormatter::success([
                $ticket
            ], 'Berhasil mengambil units');
        } catch (Throwable $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal');
        }

    }
}

