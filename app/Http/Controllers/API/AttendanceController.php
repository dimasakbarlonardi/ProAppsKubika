<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Karyawan;
use App\Models\Site;
use App\Models\Coordinate;
use App\Models\PermitAttendance;
use App\Models\ShiftType;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkTimeline;
use Carbon\Carbon;
use DateTime;
use Image;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use stdClass;

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
                'lat' => $coor->latitude,
                'long' => $coor->longitude,
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

                        try {
                            DB::beginTransaction();
                            $karyawan->NowSchedule->check_in = Carbon::now();
                            $karyawan->NowSchedule->checkin_lat = $request->my_lat;
                            $karyawan->NowSchedule->checkin_long = $request->my_long;
                            $karyawan->NowSchedule->status_absence = $status_absence;

                            $file = $request->file('photo');

                            if ($file) {
                                $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'checkin', $file);
                                $karyawan->NowSchedule->checkin_photo = $storagePath;
                            }

                            $karyawan->NowSchedule->save();
                            DB::commit();
                        } catch (\Throwable $e) {
                            DB::rollBack();
                            dd($e);
                        }

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

        $lat = $request->my_lat;
        $long = $request->my_long;

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
                        $file = $request->file('photo');
                        if ($file) {
                            $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'checkin', $file);
                            $karyawan->NowSchedule->checkout_photo = $storagePath;
                        }

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
            $latitude1 = $item->latitude;
            $longitude1 = $item->longitude;
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

    public function shiftSchedule(Request $request)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connAttend = ConnectionDB::setConnection(new WorkTimeline());

        $user = $connUser->where('login_user', $request->user()->email)->first();

        $getAttends = $connAttend->where('karyawan_id', $user->Karyawan->id)
            ->with('ShiftType')
            ->where('status_absence', null);

        if ($request->date) {
            $getAttends = $getAttends->where('date', $request->date);
        };

        return ResponseFormatter::success(
            $getAttends->get(),
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

    public function getShiftType()
    {
        $connShift = ConnectionDB::setConnection(new ShiftType());

        $shifts = $connShift->get();

        return ResponseFormatter::success(
            $shifts,
            'Success get all shift types'
        );
    }

    public function getScheduleByShift(Request $request, $id)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connWorkSchedule = ConnectionDB::setConnection(new WorkTimeline());

        $user = $connUser->where('login_user', $request->user()->email)->first();

        $schedules = $connWorkSchedule->where('karyawan_id', $user->Karyawan->id)
            ->where('shift_type_id', $id)
            ->where('date', $request->date)
            ->where('status_absence', null)
            ->get();

        return ResponseFormatter::success(
            $schedules,
            'Success get all schedules'
        );
    }

    public function attendanceReports(Request $request)
    {
        $connWorkSchedule = ConnectionDB::setConnection(new WorkTimeline());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $user = $request->user();
        $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();

        $reports = $connWorkSchedule->where('status_absence', '!=', null)
            ->where('karyawan_id', $karyawan->id)
            ->with(['ShiftType' => function ($q) {
                $q->select('id', 'shift', 'checkin', 'checkout');
            }])
            ->orderBy('id', 'DESC')
            ->get();

        return ResponseFormatter::success(
            $reports,
            'Success get all reports'
        );
    }

    public function showAttendanceReport(Request $request, $id)
    {
        $connWorkSchedule = ConnectionDB::setConnection(new WorkTimeline());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connCoor = ConnectionDB::setConnection(new Coordinate());

        $user = $request->user();
        $karyawan = $connKaryawan->where('email_karyawan', $user->email)->first();

        $report = $connWorkSchedule->where('id', $id)
            ->select(
                'check_in',
                'check_out',
                'checkin_lat',
                'checkin_long',
                'work_hour',
                'checkin_photo',
                'checkout_photo',
                'shift_type_id',
                'status_absence'
            )
            ->with(['ShiftType' => function ($q) {
                $q->select('id', 'shift', 'checkin', 'checkout');
            }])
            ->where('status_absence', '!=', null)
            ->where('karyawan_id', $karyawan->id)
            ->orderBy('id', 'DESC')
            ->first();

        $report['work_break'] = '1 Hour';

        if ($report->checkin_lat && $report->checkin_long) {
            $siteLoc = $connCoor->select(
                "site_name",
                "barcode_image",
                DB::raw(
                    "
                        (6371 * acos(
                                cos(radians($report->checkin_lat)) *
                                cos(radians(latitude)) *
                                cos(radians(longitude) - radians($report->checkin_long)) +
                                sin(radians($report->checkin_lat)) *
                                sin(radians(latitude))
                                )
                        ) as distance
                        "
                )
            )
                ->having("distance", '<', 10)
                ->first();

            $report->attendance_location = $siteLoc->site_name;
            $report->attendance_barcode = $siteLoc->barcode_image;
            $report->status_absence = 'Present';
        } else {
            $report->attendance_location = $connCoor->find(1)->site_name;
            $report->attendance_barcode = $connCoor->find(1)->barcode_image;
            $report->status_absence = $report->status_absence;
        }


        return ResponseFormatter::success(
            $report,
            'Success get report'
        );
    }

    public function permitAttendance(Request $request)
    {
        $connPermit = ConnectionDB::setConnection(new PermitAttendance());
        $connSchedule = ConnectionDB::setConnection(new WorkTimeline());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());

        $karyawan = $connKaryawan->where('email_karyawan', $request->user()->email)->first();
        $schedule = $connSchedule->where('date', $request->work_date)
            ->where('karyawan_id', $karyawan->id)
            ->first();

        if ($schedule) {
            if (
                !$schedule->status_absence &&
                $request->permit_type != 'Sick' &&
                $request->permit_type != 'Forgot Clock In' &&
                $request->permit_type != 'Anual Leave' &&
                $request->permit_type != 'Special Leave' &&
                $request->permit_type != 'Change Shift'
            ) {
                return ResponseFormatter::error(
                    null,
                    "Sorry, you haven't chock in yet"
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                "Sorry, you dont have schedule on selected date"
            );
        }

        $connPermit->karyawan_id = $karyawan->id;
        $connPermit->work_date = $request->work_date;
        $connPermit->permit_type = $request->permit_type;
        $connPermit->permit_title = $request->permit_title;
        $connPermit->permit_desc = $request->permit_desc;
        $connPermit->request_time = $request->request_time;
        $connPermit->previous_shift_id = $request->previous_shift_id;
        $connPermit->replace_shift_id = $request->replace_shift_id;
        $connPermit->replacement_id = $request->replacement_id;
        $connPermit->status_permit = 'PENDING';

        $photo = $request->file('photo');
        if ($photo) {
            $storagePath = SaveFile::saveToStorage($request->user()->id_site, 'permit-attendance', $photo);
            $connPermit->permit_photo = $storagePath;
        }
        $file = $request->file('file');
        if ($file) {
            $storagePathFile = SaveFile::saveFileToStorage($request->user()->id_site, 'permit-attendance', $file);
            $connPermit->permit_file = $storagePathFile;
        }

        $connPermit->save();

        return ResponseFormatter::success(
            $connPermit,
            'Success create ' . $request->permit_type . ' report'
        );
    }
}
