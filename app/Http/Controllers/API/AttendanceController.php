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

        return ResponseFormatter::success([
            'lat' => $site->lat,
            'long' => $site->long,
        ], 'Success get site location');
    }

    function attend($user)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connAttend = ConnectionDB::setConnection(new Attendance());

        $data['getUser'] = $connUser->where('login_user', $user->email)->first();

        $data['attend'] = $connAttend->where('id_user', $data['getUser']->id_user)
            ->where('status', 'On Work')
            ->first();

        return $data;
    }

    public function checkin(Request $request, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);

            $attend = $this->attend($user);
            $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();

            if ($karyawan->NowSchedule) {
                if (!$attend['attend']) {
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

                        $connAttend = ConnectionDB::setConnection(new Attendance());

                        $connAttend->create([
                            'id_site' => $site->id_site,
                            'id_user' => $attend['getUser']->id_user,
                            'check_in' =>  Carbon::now(),
                            'status' => 'On Work',
                            'status_absence' => $status_absence
                        ]);

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

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);

            $data = $this->attend($user);
            $attend = $data['attend'];

            if ($attend) {
                $site_lat = $site->lat;
                $site_long = $site->long;
                $my_lat = $request->my_lat;
                $my_long = $request->my_long;

                $connKaryawan = ConnectionDB::setConnection(new Karyawan());

                $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();

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
                    $attend->work_hour = $work_hour;
                    $attend->check_out = $checkout;
                    $attend->status = 'Finish';
                    $attend->save();

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
}
