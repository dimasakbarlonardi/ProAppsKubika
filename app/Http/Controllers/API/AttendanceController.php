<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Karyawan;
use App\Models\Site;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkTimeline;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AttendanceController extends Controller
{
    public function siteLocation(Request $request)
    {
        $user = $request->user();
        $site = Site::find($user->id_site);

        $data = [];

        $coordinate = [
            'site_name' => 'Holding',
            'lat' => $site->lat,
            'long' => $site->long,
        ];

        $data[] = $coordinate;

        return ResponseFormatter::success(
            $data,
            'Success get site location');
    }

    function attend($karyawan)
    {
        $connAttend = ConnectionDB::setConnection(new WorkTimeline());

        $attend = $connAttend->where('karyawan_id', $karyawan->id)
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('status_absence', null)
            ->first();

        return $attend;
    }

    function attendCheckout($karyawan)
    {
        $connAttend = ConnectionDB::setConnection(new WorkTimeline());

        $attend = $connAttend->where('karyawan_id', $karyawan->id)
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('check_in', '!=', null)
            ->where('check_out', null)
            ->first();

        return $attend;
    }

    public function checkin(Request $request, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);

            $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();
            $attend = $this->attend($karyawan);
            // dd($attend);
            if ($karyawan->NowSchedule) {
                if ($attend) {
                    $site_lat = $site->lat;
                    $site_long = $site->long;
                    $my_lat = $request->my_lat;
                    $my_long = $request->my_long;

                    $distance = $this->getDistance($site_lat, $site_long, $my_lat, $my_long);

                    $checkin = Carbon::now()->format('H:i');

                    if ($distance < 0.03) {
                        $start_hour = $karyawan->NowSchedule->ShiftType->checkin;
                        $start_hour = '22:00'; //temporary just for dev
                        if ($checkin > $start_hour) {
                            $status_absence = 'Late';
                        } elseif ($checkin < $start_hour) {
                            $status_absence = 'Early';
                        } elseif ($checkin == $start_hour) {
                            $status_absence = 'On Time';
                        }
                        // dd($karyawan->NowSchedule);
                        // $connAttend = ConnectionDB::setConnection(new Attendance());
                        $karyawan->NowSchedule->check_in = Carbon::now();
                        $karyawan->NowSchedule->status_absence = $status_absence;
                        $karyawan->NowSchedule->save();
                        // $connAttend->create([
                        //     'id_site' => $site->id_site,
                        //     'id_user' => $attend['getUser']->id_user,
                        //     'check_in' =>  Carbon::now(),
                        //     'status' => 'On Work',
                        //     'status_absence' => $status_absence
                        // ]);

                        return response()->json([
                            'status' => 'OK',
                            'Message' => 'Within 30 meter radius'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'FAIL',
                            'Message' => 'Outside 30 meter radius'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'FAIL',
                        'Message' => 'Already Checkin'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'FAIL',
                    'Message' => 'You dont have schedule today'
                ]);
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }

        $lat = $request->lat;
        $long = $request->long;

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

    public function checkout(Request $request, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $user = $tokenable->tokenable;
        $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();
        $attend = $this->attendCheckout($karyawan);
        $site = Site::find($user->id_site);

        if ($tokenable) {
            if ($attend && !$attend->checkout) {
                if ($attend) {
                    $site_lat = $site->lat;
                    $site_long = $site->long;
                    $my_lat = $request->my_lat;
                    $my_long = $request->my_long;

                    $distance = $this->getDistance($site_lat, $site_long, $my_lat, $my_long);
                    $checkin = new DateTime($attend->check_in);
                    $checkout = Carbon::now();
                    $checkout = '2023-01-02 09:00'; //temporary just for dev
                    $work_hour = $checkin->diff(new DateTime($checkout));


                    if ($work_hour->format('%h') == 0) {
                        $work_hour = $work_hour->format('%i') . " Minutes";
                    } else {
                        $work_hour = $work_hour->format('%h') . " Hours " . $work_hour->format('%i') . " Minutes";
                    }

                    if ($distance < 0.03) {
                        $karyawan->NowSchedule->work_hour = $work_hour;
                        $karyawan->NowSchedule->check_out = $checkout;
                        $karyawan->NowSchedule->save();

                        return response()->json([
                            'status' => 'OK',
                            'Message' => 'Within 30 meter radius'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'FAIL',
                            'Message' => 'Outside 30 meter radius'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'FAIL',
                        'Message' => 'Not checkin yet'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'FAIL',
                    'Message' => 'Already checkout'
                ]);
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
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

    public function shiftSchedule($userID)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connAttend = ConnectionDB::setConnection(new WorkTimeline());

        $user = $connUser->find($userID);

        $getAttends = $connAttend->where('karyawan_id', $user->Karyawan->id)
            ->with('ShiftType')
            ->where('status_absence', null)
            ->get();

        return ResponseFormatter::success(
            $getAttends,
            'Success get site location'
        );
    }
}
