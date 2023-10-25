<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\PermitAttendance;
use App\Models\RequestAttendance;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class RequestAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new PermitAttendance());

        $data['permit_attendances'] = $conn->get();

        return view('AdminSite.RequestAttendance.index', $data);
    }

    public function approvePermitAttendance($id)
    {
        $conn = ConnectionDB::setConnection(new PermitAttendance());

        $permit = $conn->find($id);
        $work_schedule = $permit->WorkTimeline($permit->work_date);

        $permit->status_permit = 'APPROVED';
        $work_schedule->status_absence = $permit->permit_type;

        if ($permit->permit_type == 'Early Permit') {
            $this->EarlyPermit($permit, $work_schedule);
        }

        if ($permit->permit_type == 'Late Permit') {
            $this->LatePermit($permit, $work_schedule);
        }

        if ($permit->permit_type == 'Forgot Clock In') {
            $this->ForgetClockIn($permit, $work_schedule);
        }

        if ($permit->permit_type == 'Forgot Clock Out') {
            $this->ForgetClockOut($permit, $work_schedule);
        }

        if ($permit->permit_type == 'Change Shift') {
            $this->ChangeShift($permit, $work_schedule);
            $work_schedule->status_absence = null;
        }

        $permit->save();
        $work_schedule->save();

        return response()->json(['status' => 'ok']);
    }

    function EarlyPermit($permit, $work_schedule)
    {
        $checkout = new DateTime(Carbon::now()->format('Y-m-d') . ' ' . $permit->request_time);

        $work_schedule->check_out = $checkout;
        $work_schedule->work_hour = '8 Hours';

        return $work_schedule;
    }

    function LatePermit($permit, $work_schedule)
    {
        $checkin = new DateTime(Carbon::now()->format('Y-m-d') . ' ' . $permit->request_time);

        $work_schedule->check_in = $checkin;

        return $work_schedule;
    }

    function ForgetClockIn($permit, $work_schedule)
    {
        $checkin = new DateTime($permit->work_date . ' ' . $permit->request_time);

        $work_schedule->check_in = $checkin;

        return $work_schedule;
    }

    function ForgetClockOut($permit, $work_schedule)
    {
        $checkout = new DateTime(Carbon::now()->format('Y-m-d') . ' ' . $permit->request_time);
        $checkin = new DateTime($work_schedule->check_in);

        $work_hour = $checkin->diff($checkout);

        if ($work_hour->format('%h') == 0) {
            $work_hour = $work_hour->format('%i') . " Minutes";
        } else {
            $work_hour = $work_hour->format('%h') . " Hours " . $work_hour->format('%i') . " Minutes";
        }

        $work_schedule->check_out = $checkout;
        $work_schedule->work_hour = $work_hour;

        return $work_schedule;
    }

    function ChangeShift($permit, $work_schedule)
    {
        $work_schedule->shift_type_id = $permit->replace_shift_id;
        $work_schedule->karyawan_id = $permit->replacement_id;

        return $work_schedule;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
