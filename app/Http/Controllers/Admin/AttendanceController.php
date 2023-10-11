<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Karyawan;
use App\Models\Coordinate;
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

    public function coordinates()
    {
        $connCoordinates = ConnectionDB::setConnection(new Coordinate());

        $data['coordinates'] = $connCoordinates->get();

        foreach ($data['coordinates'] as $coor) {
            $coor->generateBarcode();
        }

        return view('AdminSite.Attendance.coordinates', $data);
    }
}
