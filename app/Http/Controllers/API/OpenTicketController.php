<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\CashReceipt;
use App\Models\JenisRequest;
use App\Models\OpenTicket;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;
use Throwable;

class OpenTicketController extends Controller
{
    public function user()
    {
        $connUser = ConnectionDB::setConnection(new User());

        $user = $connUser->where('login_user', Auth::user()->email)->first();

        return $user;
    }
    public function listTickets()
    {
        $user = $this->user();

        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());

        $tickets = $connOpenTicket->where('id_tenant', $user->Tenant->id_tenant)
            ->get();

        return ResponseFormatter::success(
            $tickets,
            'Berhasil mengambil semua tickets'
        );
    }
    public function jenisRequest(Request $request)
    {
        $connJenisReq = ConnectionDB::setConnection(new JenisRequest());

        $jenis_requests = $connJenisReq->get();

        return ResponseFormatter::success([
            $jenis_requests
        ], 'Berhasil mengambil jenis request');
    }

    public function store(Request $request)
    {
        $tenant = $this->user()->Tenant->id_tenant;

        $rules = [
            'id_jenis_request' => 'required',
        ];
        $message = [
            'required' => 'The :attribute field is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            dd($validator);
            return ResponseFormatter::error(
                null,
                'Gagal membuat ticket, harap mengisi semua form'
            );
        }
        $connOpenTicket = ConnectionDB::setConnection(new OpenTicket());
        $connSystem = ConnectionDB::setConnection(new System());
        $connUnit = ConnectionDB::setConnection(new Unit());

        $system = $connSystem->find(1);
        $count = $system->sequence_notiket + 1;

        $nowDate = Carbon::now();
        try {
            DB::beginTransaction();
            $unit = $connUnit->find($request->id_unit);

            $no_tiket = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_tiket . '/' .
                Carbon::now()->format('m') . $nowDate->year . '/' .
                sprintf("%06d", $count);

            $createTicket = $connOpenTicket->create($request->all());
            $createTicket->id_jenis_request = $request->id_jenis_request;
            $createTicket->judul_request = $request->judul_request;
            $createTicket->id_site = $unit->id_site;
            $createTicket->id_tenant = $tenant;
            $createTicket->id_tower = $unit->id_tower;
            $createTicket->id_unit = $request->id_unit;
            $createTicket->id_lantai = $unit->id_lantai;
            $createTicket->no_tiket = $no_tiket;
            $createTicket->status_request = 'PENDING';
            $createTicket->deskripsi_request = $request->deskripsi_request;
            $createTicket->no_hp = $request->no_hp;

            $file = $request->file('upload_image');

            if ($file) {
                $fileName = $createTicket->id . '-' .   $file->getClientOriginalName();
                $outputTicketImage = '/public/' . $unit->id_site . '/img/ticket/' . $fileName;
                $ticketImage = '/storage/' . $unit->id_site . '/img/ticket/' . $fileName;

                Storage::disk('local')->put($outputTicketImage, File::get($file));

                $createTicket->upload_image = $ticketImage;
            }

            $createTicket->save();
            $system->sequence_notiket = $count;
            $system->save();
            $dataNotif = [
                'models' => 'OpenTicket',
                'notif_title' => $createTicket->no_tiket,
                'id_data' => $createTicket->id,
                'sender' => $this->user()->id_user,
                'division_receiver' => 1,
                'notif_message' => 'Tiket sudah dibuat, mohon proses request saya',
                'receiver' => null,
            ];

            $system->save();
            $createTicket->save();

            broadcast(new HelloEvent($dataNotif));

            DB::commit();

            return ResponseFormatter::success([
                $createTicket
            ], 'Berhasil membuat ticket');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal membuat ticket');
        }
    }

    public function show($id)
    {
        $connRequest = ConnectionDB::setConnection(new OpenTicket());

        $ticket = $connRequest->where('id', $id)->with('Tenant')->first();
        $ticket->deskripsi_request = strip_tags($ticket->deskripsi_request);
        $ticket->deskripsi_respon = strip_tags($ticket->deskripsi_respon);

        return ResponseFormatter::success(
            $ticket,
            'Berhasil mengambil request'
        );
    }

    public function payableTickets($id)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());

        $tickets = $connTicket->where('no_invoice', '!=', null)
            ->where('id_unit', $id)
            ->with('CashReceipt')
            ->get();

        return ResponseFormatter::success(
            $tickets
        , 'Success get transactions');
    }
}
