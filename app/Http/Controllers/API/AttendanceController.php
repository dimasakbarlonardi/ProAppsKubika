<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Karyawan;
use App\Models\Site;
use App\Models\Coordinate;
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
        $conCoordinates = ConnectionDB::setConnection(new Coordinate());

        $data = $conCoordinates->get();

        return ResponseFormatter::success(
            $data,
            'Success get site location'
        );
    }

    public function showLocation($id, $token)
    {
        $conCoordinate = ConnectionDB::setConnection(new Coordinate());

        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $coor = $conCoordinate->find($id);
            $data = [
                'lat' => $coor->lat,
                'long' => $coor->long,
            ];

            return ResponseFormatter::success(
                $data,
                'Success get site location'
            );
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
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

            $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();
            $attend = $this->attend($karyawan);

            if ($karyawan->NowSchedule) {
                if ($attend) {
                    $my_lat = $request->my_lat;
                    $my_long = $request->my_long;

                    $distance = $this->getDistance($my_lat, $my_long);

                    $checkin = Carbon::now()->format('H:i');

                    if ($distance < 10) {
                        $start_hour = $karyawan->NowSchedule->ShiftType->checkin;
                        if ($checkin > $start_hour) {
                            $status_absence = 'Late';
                        } elseif ($checkin < $start_hour) {
                            $status_absence = 'Early';
                        } elseif ($checkin == $start_hour) {
                            $status_absence = 'On Time';
                        }

                        $karyawan->NowSchedule->check_in = Carbon::now();
                        $karyawan->NowSchedule->status_absence = $status_absence;
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

        $distance = $this->getDistance($lat, $long);
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

                    $my_lat = $request->my_lat;
                    $my_long = $request->my_long;

                    $distance = $this->getDistance($my_lat, $my_long);
                    $checkin = new DateTime($attend->check_in);
                    $checkout = Carbon::now();

                    $work_hour = $checkin->diff(new DateTime($checkout));


                    if ($work_hour->format('%h') == 0) {
                        $work_hour = $work_hour->format('%i') . " Minutes";
                    } else {
                        $work_hour = $work_hour->format('%h') . " Hours " . $work_hour->format('%i') . " Minutes";
                    }

                    if ($distance < 10) {
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


    function getDistance($latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $conCoordinates = ConnectionDB::setConnection(new Coordinate());

        $coordinates = $conCoordinates->get();

        foreach ($coordinates as $item) {
            $latitude1 = $item->lat;
            $longitude1 = $item->long;
        }

        if ($latitude1 && $longitude1) {
            $dLat = deg2rad($latitude2 - $latitude1);
            $dLon = deg2rad($longitude2 - $longitude1);

            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * asin(sqrt($a));
            $d = $earth_radius * $c;

            return $d;
        }

        $resp = "Outside 10000 meter radius";

        return response()->json(['status' => $resp]);
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

    public function todayData($userID)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connAttend = ConnectionDB::setConnection(new WorkTimeline());

        $user = $connUser->find($userID);

        $getAttends = $connAttend->where('karyawan_id', $user->Karyawan->id)
            ->with('ShiftType')
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->first();

        return ResponseFormatter::success(
            $getAttends,
            'Success get site location'
        );
    }

    public function recentData($userID)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connAttend = ConnectionDB::setConnection(new WorkTimeline());

        $user = $connUser->find($userID);

        $getAttends = $connAttend->where('karyawan_id', $user->Karyawan->id)
            ->with('ShiftType')
            ->orderBy('created_at', 'DESC')
            ->get();

        return ResponseFormatter::success(
            $getAttends[1],
            'Success get site location'
        );
    }
}
