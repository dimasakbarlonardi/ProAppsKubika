<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $site = Site::find('004212');

        $data['site'] = $site;

        return view('gis', $data);
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

    public function attendace()
    {
        return view('/gis');
    }
}
