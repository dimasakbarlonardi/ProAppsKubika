<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Karyawan;
use App\Models\Site;
use App\Models\User;
use App\Models\WorkTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        // $nowDate = Carbon::now()->format('Y-m-d');
        // $attendances = DB::connection('park-royale')
        //     ->table('tb_work_timeline as wt')
        //     ->select('u.id_user', 'wt.date', 'shift_type_id', 'u.id_site')
        //     ->join('tb_karyawan as k', 'k.id_karyawan', '=', 'wt.karyawan_id')
        //     ->join('tb_user as u', 'u.login_user', '=', 'k.email_karyawan')
        //     ->get();

        // foreach ($attendances as $schedule) {
        //     $attendance = new Attendance();
        //     $attendance->setConnection('park-royale');

        //     $currAttendance = $attendance->where('date_schedule', $schedule->date)
        //         ->first();

        //     $status = $nowDate > $schedule->date;
        //     if ($status && !$currAttendance) {
        //         $attendance->id_site = $schedule->id_site;
        //         $attendance->id_user = $schedule->id_user;
        //         $attendance->status_absence = 'Alpha';
        //         $attendance->date_schedule = $schedule->date;
        //         $attendance->status = 'Finish';
        //         $attendance->save();
        //     }
        // }

        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $data['karyawans'] = $connKaryawan
            ->where('deleted_at', null)
            ->with('User.Attendance')
            ->get();

        $data['nowDate'] = '2023-10-01';

        return view('AdminSite.Attendance.index', $data);
    }

    public function presenceByMonth(Request $request)
    {
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $data['karyawans'] = $connKaryawan
            ->where('deleted_at', null)
            ->with('User.Attendance')
            ->get();

        $data['nowDate'] = $request->month;

        return response()->json([
            'html' => view('AdminSite.Attendance.attendance_table', $data)->render()
        ]);
    }

    public function absence(Request $request)
    {
        $site = Site::find('004212');

        $lat = $request->my_lat;
        $long = $request->my_long;

        $site_lat = $site->lat;
        $site_long = $site->long;

        $distance = $this->getDistance($site_lat, $site_long, $lat, $long);
        if ($distance < 0.03) {
            $resp = "Within 30 meter radius";
        } else {
            $resp = "Outside 30 meter radius";
        }

        return response()->json(['status' => $resp]);
    }

    function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }
}
