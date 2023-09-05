<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\ScheduleSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ScheduleSecurity());

        $data['schedulesec'] = $conn->get();

        return view('AdminSite.ScheduleSecurity.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = ConnectionDB::setConnection(new Room());

        $data['rooms'] = $room->get();

        return view('AdminSite.ScheduleSecurity.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $conn = ConnectionDB::setConnection(new ScheduleSecurity());

            $conn->create([
                'id_room' => $request->id_room,
                'schedule' => $request->schedule,
            ]);
            
            DB::commit();

            Alert::success('Success', 'Successfully Added Schedule Security');

            return redirect()->route('schedulesecurity.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Schedule Security');

            return redirect()->route('schedulesecurity.index');
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
