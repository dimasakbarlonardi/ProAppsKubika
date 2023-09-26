<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\EmployeeMeeting;
use App\Models\Room;
use App\Models\ScheduleMeeting;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ScheduleMeeting());

        $data['schedulemeeting'] = $conn->get();

        return view('AdminSite.ScheduleMeeting.index', $data);
    }

    public function dataEmployee($id)
    {
        $Employee = ConnectionDB::setConnection(new Karyawan());
        $room = ConnectionDB::setConnection(new Room());

        $data['rooms'] = $room->get();
        $data['parameters'] = $Employee->get();
        $data['id'] = $id;
        return view('AdminSite.ScheduleMeeting.data', $data);
    }

    public function employeeMeeting($id_meeting)
    {
        $Employee = ConnectionDB::setConnection(new EmployeeMeeting());
        $data['employee'] = $Employee->where('id_meeting', $id_meeting)->get();
    
        return view('AdminSite.ScheduleMeeting.employee', $data);
    }

    public function storedataEmployee(Request $request)
    {
        try {
            // Mulai transaksi database
            DB::beginTransaction();
    
            // Simpan data ke dalam tabel ScheduleMeeting
            $scheduleMeeting = ConnectionDB::setConnection(new ScheduleMeeting());
            $scheduleMeeting->meeting = $request->meeting;
            $scheduleMeeting->id_room = $request->id_room;
            $scheduleMeeting->date = $request->date;
            $scheduleMeeting->time_in = $request->time_in;
            $scheduleMeeting->time_out = $request->time_out;
            $scheduleMeeting->save();
    
            // Simpan data ke dalam tabel EmployeeMeeting jika parameter tidak kosong
            $parameter = $request->to;
            if (!empty($parameter)) {
                foreach ($parameter as $form) {

                    $employeeMeeting = ConnectionDB::setConnection(new EmployeeMeeting());
                    $employeeMeeting->id_meeting = $scheduleMeeting->id;
                    $employeeMeeting->id_karyawan = $form;
                    $employeeMeeting->save();
                }
            }
    
            // Commit transaksi jika semuanya berhasil
            DB::commit();
    
            // Tampilkan pesan sukses
            Alert::success('Success', 'Successfully Added Schedule Meeting');
    
            return redirect()->route('schedulemeeting.index');
        } catch (\Throwable $e) {
            // Jika ada kesalahan, rollback transaksi
            DB::rollBack();
    
            // Tampilkan pesan kesalahan dan log kesalahan
            dd($e);
            Alert::error('Failed', 'Failed to Add Schedule Meeting');
    
            return redirect()->route('schedulemeeting.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = ConnectionDB::setConnection(new Room());
        $Employee = ConnectionDB::setConnection(new Karyawan());
    
        $data['rooms'] = $room->get();
        $data['parameters'] = $Employee->get();

    
        return view('AdminSite.ScheduleMeeting.create', $data);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
{
    try {
        // Mulai transaksi database
        DB::beginTransaction();

        // Simpan data ke dalam tabel ScheduleMeeting
        $scheduleMeeting = ConnectionDB::setConnection(new ScheduleMeeting());
        $scheduleMeeting->meeting = $request->meeting;
        $scheduleMeeting->id_room = $request->id_room;
        $scheduleMeeting->date = $request->date;
        $scheduleMeeting->time_in = $request->time_in;
        $scheduleMeeting->time_out = $request->time_out;
        $scheduleMeeting->save();

        // Simpan data ke dalam tabel EmployeeMeeting jika parameter tidak kosong
        $parameter = $request->to;
        if (!empty($parameter)) {
            foreach ($parameter as $form) {
                $employeeMeeting = ConnectionDB::setConnection(new EmployeeMeeting());
                $employeeMeeting->id_meeting = $id;
                $employeeMeeting->id_karyawan = $form;
                $employeeMeeting->save();
            }
        }

        // Commit transaksi jika semuanya berhasil
        DB::commit();

        // Tampilkan pesan sukses
        Alert::success('Success', 'Successfully Added Schedule Meeting');

        return redirect()->route('schedulemeeting.index');
    } catch (\Throwable $e) {
        // Jika ada kesalahan, rollback transaksi
        DB::rollBack();

        // Tampilkan pesan kesalahan dan log kesalahan
        dd($e);
        Alert::error('Failed', 'Failed to Add Schedule Meeting');

        return redirect()->route('schedulemeeting.index');
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
