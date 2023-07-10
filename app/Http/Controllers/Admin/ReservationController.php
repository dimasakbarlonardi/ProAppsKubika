<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Approve;
use App\Models\JenisAcara;
use App\Models\Notifikasi;
use App\Models\OpenTicket;
use App\Models\Reservation;
use App\Models\RuangReservation;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionCenter;
use App\Models\TypeReservation;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use stdClass;
use Throwable;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $connReqRev = ConnectionDB::setConnection(new Reservation());
        $connApprove = ConnectionDB::setConnection(new Approve());

        $data['user'] = $request->session()->get('user');
        $data['approve'] = $connApprove->find(7);
        $data['reservations'] = $connReqRev->get();

        return view('AdminSite.RequestReservation.index', $data);
    }

    public function create()
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connTypeRsv = ConnectionDB::setConnection(new TypeReservation());
        $connRuangRsv = ConnectionDB::setConnection(new RuangReservation());
        $connJenisAcara = ConnectionDB::setConnection(new JenisAcara());

        $data['typeRsv'] = $connTypeRsv->get();
        $data['ruangRsv'] = $connRuangRsv->get();
        $data['jenisAcara'] = $connJenisAcara->get();
        $data['tickets'] = $connTicket->where('status_request', 'PROSES KE RESERVASI')->get();

        return view('AdminSite.RequestReservation.create', $data);
    }

    public function store(Request $request)
    {
        $connTicket = ConnectionDB::setConnection(new OpenTicket());
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connSystem = ConnectionDB::setConnection(new System());
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();

            $system = $connSystem->find(1);
            $ticket = $connTicket->find($request->no_tiket);
            $count = $system->sequence_no_reservation + 1;

            $no_reservation = $system->kode_unik_perusahaan . '/' .
                $system->kode_unik_reservation . '/' .
                Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
                sprintf("%06d", $count);

            $createRsv = $connReservation->create([
                'no_tiket' => $ticket->no_tiket,
                'no_request_reservation' => $no_reservation,
                'tgl_request_reservation' => $request->tgl_request_reservation,
                'id_type_reservation' => $request->id_type_reservation,
                'id_ruang_reservation' => $request->id_ruang_reservation,
                'id_jenis_acara' => $request->id_jenis_acara,
                'keterangan' => $request->keterangan,
                'durasi_acara' => $request->durasi_acara . ' ' . $request->satuan_durasi_acara,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_akhir' => $request->waktu_akhir,
                'jumlah_deposit' => $request->jumlah_deposit,
                'status_bayar' => 'PENDING',
            ]);

            $ticket->status_request = 'PROSES';
            $ticket->save();

            $connNotif = ConnectionDB::setConnection(new Notifikasi());
            $checkNotif = $connNotif->where('models', 'Reservation')
                ->where('is_read', 0)
                ->where('id_data', $createRsv->id)
                ->first();

            if (!$checkNotif) {
                $connNotif->create([
                    'receiver' => $ticket->Tenant->User->id_user,
                    'sender' => $user->id_user,
                    'is_read' => 0,
                    'models' => 'Reservation',
                    'id_data' => $createRsv->id,
                    'notif_title' => $createRsv->no_request_reservation,
                    'notif_message' => 'Request Reservation diterima, mohon mengisi form reservasi'
                ]);
            }

            $system->sequence_no_reservation = $count;
            $system->save();

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan request');

            return redirect()->route('request-reservations.index');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back();
        }
        dd($ticket);
    }

    public function approve1($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->sign_approval_1 = Carbon::now();
        $rsv->save();

        Alert::success('Berhasil', 'Berhasil approve reservasi');

        return redirect()->back();
    }

    public function approve2(Request $request, $id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());
        $connSystem = ConnectionDB::setConnection(new System());
        $connTransaction = ConnectionDB::setConnection(new Transaction());

        $system = $connSystem->find(1);
        $count = $system->sequence_no_invoice + 1;

        $no_invoice = $system->kode_unik_perusahaan . '/' .
            $system->kode_unik_invoice . '/' .
            Carbon::now()->format('m') . Carbon::now()->format('Y') . '/' .
            sprintf("%06d", $count);

        $admin_fee = 5000;

        $user = $request->session()->get('user');
        $rsv = $connReservation->find($id);
        $total = $rsv->jumlah_deposit + $admin_fee;

        try {
            DB::beginTransaction();
            $rsv->sign_approval_2 = Carbon::now();
            $rsv->save();

            $createTransaction = $connTransaction;
            $createTransaction->no_invoice = $no_invoice;
            $createTransaction->transaction_type = 'Reservation';
            $createTransaction->no_transaction = $rsv->no_request_reservation;
            $createTransaction->admin_fee = $admin_fee;
            $createTransaction->sub_total = $rsv->jumlah_deposit;
            $createTransaction->total = $total;
            $createTransaction->id_user = $rsv->Ticket->Tenant->User->id_user;
            $createTransaction->status = 'PENDING';
            $createTransaction->save();

            $ct = $this->transactionCenter($createTransaction);

            $items = [];
            $item = new stdClass();
            $item->id = 1;
            $item->quantity = 1;
            $item->detil_pekerjaan = 'Deposit Reservasi';
            $item->detil_biaya_alat = $rsv->jumlah_deposit;
            array_push($items, $item);

            $midtrans = new CreateSnapTokenService($ct, $createTransaction, $items, $admin_fee);

            $ct->snap_token = $midtrans->getSnapToken();
            $ct->save();

            $createTransaction->save();

            $system->sequence_no_invoice = $count;
            $system->save();

            $connNotif = ConnectionDB::setConnection(new Notifikasi());
            $checkNotif = $connNotif->where('models', 'Transaction')
                ->where('is_read', 0)
                ->where('id_data', $id)
                ->first();

            if (!$checkNotif) {
                $connNotif->create([
                    'receiver' => $rsv->Ticket->Tenant->User->id_user,
                    'sender' => $user->id_user,
                    'is_read' => 0,
                    'models' => 'Transaction',
                    'id_data' => $createTransaction->id,
                    'notif_title' => $createTransaction->no_invoice,
                    'notif_message' => 'Request Reservation diterima, mohon membayar deposit untuk melanjutkan proses reservasi'
                ]);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal');

            return redirect()->back();
        }

        Alert::success('Berhasil', 'Berhasil approve reservasi');

        return redirect()->back();
    }

    public function transactionCenter($transaction)
    {
        $request = Request();
        $user = $request->session()->get('user');

        try {
            DB::beginTransaction();
            $ct = TransactionCenter::create([
                'id_sites' => $user->id_site,
                'no_invoice' => $transaction->no_invoice,
                'transaction_type' => $transaction->transaction_type,
                'no_transaction' => $transaction->no_transaction,
                'admin_fee' => $transaction->admin_fee,
                'sub_total' => $transaction->sub_total,
                'total' => $transaction->total,
                'id_user' => $transaction->id_user,
                'status' => $transaction->status,
            ]);
            DB::commit();

            return $ct;
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back();
        }
    }

    public function approve3($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->sign_approval_3 = Carbon::now();
        $rsv->save();

        Alert::success('Berhasil', 'Berhasil approve reservasi');

        return redirect()->back();
    }

    public function rsvDone($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->Ticket->status_request = 'DONE';
        $rsv->Ticket->save();

        Alert::success('Berhasil', 'Berhasil update reservasi');

        return redirect()->back();
    }

    public function rsvComplete($id)
    {
        $connReservation = ConnectionDB::setConnection(new Reservation());

        $rsv = $connReservation->find($id);

        $rsv->sign_approval_4 = Carbon::now();
        $rsv->save();
        $rsv->Ticket->status_request = 'COMPLETE';
        $rsv->Ticket->save();

        Alert::success('Berhasil', 'Berhasil update reservasi');

        return redirect()->back();
    }
}
