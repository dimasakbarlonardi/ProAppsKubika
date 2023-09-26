<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\ShiftType;
use App\Models\WorkTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ShiftType());

        $data['shifttype'] = $conn->get();
        return view('AdminSite.ShiftType.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ShiftType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ShiftType());
        dd($request);
        try {
            DB::beginTransaction();

            $conn->create($request->all());
            DB::commit();
            Alert::success('Success', 'Successfully Added Shift Type');

            return redirect()->route('shifttype.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Schedule Meeting');

            return redirect()->route('shifttype.index');
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
        $conn = ConnectionDB::setConnection(new ShiftType());

        $data['shift'] = $conn->where('id', $id)->first();

        return view('AdminSite.ShiftType.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ShiftType());

        $shift = $conn->find($request($id));
        $shift->update($request->all());

        Alert::success('Success', 'Successfully Updated Shift Type');
        return redirect()->route('shifttype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ShiftType());

        $conn->find($id)->delete();
        Alert::success('Success', 'Successfully Deleted Shift Type');

        return redirect()->route('shifttype.index');
    }

    public function listWorkSchedules()
    {
        $connListSchedule = ConnectionDB::setConnection(new WorkTimeline());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $data['work_schedules'] = $connListSchedule->get();
        $data['karyawans'] = $connKaryawan->get();

        return view('AdminSite.WorkSchedule.all_work_schedule', $data);
    }

    public function workSchedules($id)
    {
        $connWorkTimeline = ConnectionDB::setConnection(new WorkTimeline());
        $connShiftType = ConnectionDB::setConnection(new ShiftType());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $data['karyawan'] = $connKaryawan->find($id);
        $data['shift_types'] = $connShiftType->get();
        $data['work_timelines'] = $connWorkTimeline
            ->where('karyawan_id', $id)
            ->with(['ShiftType', 'Karyawan'])
            ->orderBy('date', 'ASC')
            ->get();

        return view('AdminSite.WorkSchedule.index', $data);
    }

    public function storeWorkSchedules(Request $request, $id)
    {
        $connWorkTimeline = ConnectionDB::setConnection(new WorkTimeline());

        $connWorkTimeline->karyawan_id = $id;
        $connWorkTimeline->shift_type_id = $request->shift_type_id;
        $connWorkTimeline->date = $request->date;

        $connWorkTimeline->save();

        Alert::success('Success', 'Successfully Deleted Shift Type');

        return redirect()->back();
    }
}
