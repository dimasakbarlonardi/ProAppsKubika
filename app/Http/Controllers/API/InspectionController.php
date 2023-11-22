<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ChecklistParameterEquiqment;
use App\Models\ChecklistSecurity;
use App\Models\EquipmentHousekeepingDetail;
use App\Models\EquiqmentAhu;
use App\Models\EngAhu;
use App\Models\EquiqmentEngineeringDetail;
use App\Models\EquiqmentToilet;
use App\Models\Toilet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;
use stdClass;

class InspectionController extends Controller
{
    public function checklistengineering(Request $request)
    {
        $connInspectionEng = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $inspection = $connInspectionEng->where('deleted_at', null)
            ->with(['Room', 'equipment', 'Schedule'])
            ->where('status_schedule', '!=', 'Not Done')
            ->get();

        foreach ($inspection as $key => $data) {
            $inspection[$key]['status'] = json_decode($data->status);
        }

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Equiqment Engineering'
        );
    }

    public function schedueinspection()
    {
        $connSchedules = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $nowMonth = Carbon::now()->format('m');
        $getSchedules = $connSchedules->whereMonth('schedule', $nowMonth)
            ->where('status_schedule', 'Not Done')
            ->with('Equipment.Room.Tower')
            ->get();

        $inspections = [];
        if ($getSchedules) {
            foreach ($getSchedules as $schedule) {
                $eq = $schedule->Equipment;

                $object = new stdClass();
                $object->id_equiqment_engineering = $schedule->id_equiqment_engineering_detail;
                $object->schedule = $schedule->schedule;
                $object->equipment = $eq->equiqment;
                $object->status_schedule = $schedule->status_schedule;

                $object->room = $eq->Room;

                $inspections[] = $object;
            }
        }

        return ResponseFormatter::success(
            $inspections,
            'Berhasil mengambil Schedule Engineering'
        );
    }

    public function storeinspectionEng(Request $request, $id)
    {
        $connSchedule = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());
        $schedule = $connSchedule->find($id);

        try {
            DB::beginTransaction();

            $file = $request->file('image');
            if ($file) {
                $fileName = $id . '-' .   $file->getClientOriginalName();
                $outputInspecImage = '/public/' . $request->user()->id_site . '/img/inspection/eng/' . $fileName;
                $inspecImage = '/storage/' . $request->user()->id_site . '/img/inspection/eng/' . $fileName;

                Storage::disk('local')->put($outputInspecImage, File::get($file));

                $schedule->image = $inspecImage;
            }
            $schedule->status = $request->status;
            $schedule->id_room = $request->id_room;
            $schedule->checklist_datetime = Carbon::now();
            $schedule->user_id = $request->user_id;

            $schedule->save();
            DB::commit();

            // Periksa dan perbarui status jadwal jika diperlukan
            if ($schedule->status_schedule == 'Not Done') {
                // Cek apakah jadwal sudah lewat (late)
                $currentDate = Carbon::now();

                if ($currentDate > $schedule->schedule) {
                    $status = 'Late';
                } elseif ($currentDate <= $schedule->schedule) {
                    $status = 'On Time';
                }

                $schedule->status_schedule = $status;

                $schedule->save();
            }

            return ResponseFormatter::success([
                $schedule
            ], 'Berhasil Inspection Engineering');
        } catch (\Throwable $e) {
            DB::rollBack();
            // dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal Inspection Engineering');
        }
    }

    public function showEngineering($id)
    {
        $connInspectionENG = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $inspection = $connInspectionENG->where('id_equiqment_engineering_detail', $id)
            ->with('Equipment.InspectionEng')
            ->first();

        $object = new stdClass();
        $object->id_equipment_engineering = $inspection->id_equiqment_engineering_detail;
        $object->schedule = $inspection->schedule;
        $object->equipment = $inspection->equipment->equiqment;
        $object->status_schedule = $inspection->status_schedule;
        $object->id_room = $inspection->equipment->Room->id_room;
        $object->room = $inspection->equipment->Room->nama_room;
        $checklists = [];

        foreach ($inspection->Equipment->InspectionEng as $data) {
            $checklists[]['question'] = $data->ChecklistEng->nama_eng_ahu;
        }
        $object->checklists = $checklists;

        return ResponseFormatter::success(
            $object,
            'Berhasil mengambil Equipment dan Data Checklist Parameter'
        );
    }

    public function showHistoryEngineering($id)
    {
        $connEquipmentDetail = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $equipment = $connEquipmentDetail->where('id_equiqment_engineering_detail', $id)
            ->with(['Room', 'Equipment'])
            ->first();

        $equipment['status'] = json_decode($equipment->status);

        return ResponseFormatter::success(
            $equipment,
            'Berhasil mengambil history inspection Engineering'
        );
    }

    //------------End Inspection Engineering------------

    // -----------------HouseKeeping--------------------

    public function checklisthousekeeping(Request $request)
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $inspection = $connInspectionHK->where('status_schedule', '!=', 'Not Done')
            ->with(['Room.Tower', 'Schedule', 'equipment'])
            ->get();

        foreach ($inspection as $key => $data) {
            $inspection[$key]['status'] = json_decode($data->status);
        }

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Equipment HouseKeeping'
        );
    }

    public function schedueinspectionhk()
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $nowMonth = Carbon::now()->format('m');
        $getSchedules = $connInspectionHK->whereMonth('schedule', $nowMonth)
            ->where('status_schedule', 'Not Done')
            ->with('Equipment.Room.Floor')
            ->get();

        $inspections = [];

        if ($getSchedules) {
            foreach ($getSchedules as $schedule) {
                $eq = $schedule->Equipment;

                $object = new stdClass();
                $object->id_equipment_housekeeping = $schedule->id_equipment_housekeeping_detail;
                $object->schedule = $schedule->schedule;
                $object->equipment = $eq->equipment;
                $object->status_schedule = $schedule->status_schedule;
                $object->room = $eq->Room;

                $inspections[] = $object;
            }
        }

        return ResponseFormatter::success(
            $inspections,
            'Berhasil mengambil Schedule HouseKeeping'
        );
    }

    public function storeinspectionHK(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());
        $schedule = $conn->find($id);

        try {
            DB::beginTransaction();

            $file = $request->file('image');

            if ($file) {
                $fileName = $id . '-' .   $file->getClientOriginalName();
                $outputInspecImage = '/public/' . $request->user()->id_site . '/img/inspection/hk/' . $fileName;
                $inspecImage = '/storage/' . $request->user()->id_site . '/img/inspection/hk/' . $fileName;

                Storage::disk('local')->put($outputInspecImage, File::get($file));

                $schedule->image = $inspecImage;
            }
            $schedule->id_room = $request->id_room;
            $schedule->status = $request->status;
            $schedule->user_id = $request->user_id;
            $schedule->checklist_datetime = Carbon::now();

            // Periksa dan perbarui status jadwal jika diperlukan
            if ($schedule->status_schedule == 'Not Done') {
                // Cek apakah jadwal sudah lewat (late)
                $currentDate = Carbon::now();

                if ($currentDate > $schedule->schedule) {
                    $status = 'Late';
                } elseif ($currentDate <= $schedule->schedule) {
                    $status = 'On Time';
                }

                $schedule->status_schedule = $status;
            }

            $schedule->save();
            DB::commit();

            return ResponseFormatter::success([
                $schedule
            ], 'Berhasil Inspection House Keeping');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal Inspection House Keeping');
        }
    }

    public function showHousekeeping($id)
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $inspection = $connInspectionHK->where('id_equipment_housekeeping_detail', $id)
            ->with('Equipment.Inspection.ChecklistHK')
            ->first();

        $object = new stdClass();
        $object->id_equipment_housekeeping = $inspection->id_equipment_housekeeping_detail;
        $object->schedule = $inspection->schedule;
        $object->equipment = $inspection->equipment->equipment;
        $object->status_schedule = $inspection->status_schedule;
        $object->id_room = $inspection->equipment->Room->id_room;
        $object->room = $inspection->equipment->Room->nama_room;

        $checklists = [];
        foreach ($inspection->Equipment->Inspection as $data) {
            $checklists[]['question'] = $data->ChecklistHK->nama_hk_toilet;
        }
        $object->checklists = $checklists;

        return ResponseFormatter::success(
            $object,
            'Berhasil mengambil Equipment dan Data Checklist Parameter'
        );
    }

    public function showHistoryHK($id)
    {
        $connInspectionDetail = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $inspection = $connInspectionDetail->where('id_equipment_housekeeping_detail', $id)
            ->with(['Room', 'Equipment', 'Schedule'])
            ->first();

        $inspection['status'] = json_decode($inspection->status);

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil history inspection HK'
        );
    }

    // ------------ end inspection -----------------

    // ---------------SECURITY-----------------

    public function checklistsecurity(Request $request)
    {
        $connInspectionSecuirty = ConnectionDB::setConnection(new ChecklistSecurity());

        $inspection = $connInspectionSecuirty
            ->where('status_schedule', '!=', 'Not Done')
            ->with(['Room.Tower', 'Room.Floor', 'Schedule', 'Shift', 'InspectionLocation'])
            ->get();

         
        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Parameter Security'
        );
    }

    public function schedueinspectionsecurity()
    {
        $connInspectionSecurity = ConnectionDB::setConnection(new ChecklistSecurity());
        
        $nowMonth = Carbon::now()->format('m');
        $getSchedules = $connInspectionSecurity->whereMonth('schedule', $nowMonth)
            ->with('Schedule.Room.Floor', 'Shift')
            ->get();

        $inspections = [];
        
        if ($getSchedules) {
            foreach ($getSchedules as $schedule) {
                $object = new stdClass();
                $object->id_parameter_security = $schedule->id;
                $object->schedule = $schedule->schedule;
                $object->shift = $schedule->Shift;
                $object->status_schedule = $schedule->status_schedule;
                $object->floor = $schedule->Room->floor;
                $object->tower = $schedule->Room->Tower;
               
                $inspections[] = $object;
            }
        }
        
        return ResponseFormatter::success(
            $inspections,
            'Berhasil mengambil Schedule Security'
        );
    }

    public function storeinspectionSecurity(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistSecurity());
        $schedule = $conn->find($id);

        try {
            DB::beginTransaction();

            $file = $request->file('image');

            if ($file) {
                $fileName = $id . '-' .   $file->getClientOriginalName();
                $outputInspecImage = '/public/' . $request->user()->id_site . '/img/inspection/security/' . $fileName;
                $inspecImage = '/storage/' . $request->user()->id_site . '/img/inspection/security/' . $fileName;

                Storage::disk('local')->put($outputInspecImage, File::get($file));

                $schedule->image = $inspecImage;
            }
            $schedule->id_room = $request->id_room;
            $schedule->id_shift = $request->id_shift;
            $schedule->status = $request->status;
            $schedule->user_id = $request->user_id;
            $schedule->checklist_datetime = Carbon::now();

            // Periksa dan perbarui status jadwal jika diperlukan
            if ($schedule->status_schedule == 'Not Done') {
                // Cek apakah jadwal sudah lewat (late)
                $currentDate = Carbon::now();

                if ($currentDate > $schedule->schedule) {
                    $status = 'Late';
                } elseif ($currentDate <= $schedule->schedule) {
                    $status = 'On Time';
                }

                $schedule->status_schedule = $status;
            }

            $schedule->save();
            DB::commit();

            return ResponseFormatter::success([
                $schedule
            ], 'Berhasil Inspection Security');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal Inspection Security');
        }
    }

    public function showSecurity($id)
    {
        $connInspectionHK = ConnectionDB::setConnection(new ChecklistSecurity());

        $inspection = $connInspectionHK->where('id', $id)
            ->with('InspectionLocation.Inspection.ChecklistSec')
            ->first();

        $object = new stdClass();
        $object->id_parameter_security = $inspection->id;
        $object->schedule = $inspection->schedule;
        $object->id_shift = $inspection->Shift->shift;
        $object->status_schedule = $inspection->status_schedule;
        $object->id_room = $inspection->InspectionLocation->Room->id_room;
        $object->room = $inspection->InspectionLocation->Room->nama_room;

        $checklists = [];
        foreach ($inspection->InspectionLocation->Inspection as $data) {
            $checklists[]['question'] = $data->ChecklistSec->name_parameter_security;
        }
        $object->checklists = $checklists;

        return ResponseFormatter::success(
            $object,
            'Berhasil mengambil Location Security dan Data Checklist Parameter'
        );
    }

    public function showHistorySecuirty($id)
    {
        $connInspectionDetail = ConnectionDB::setConnection(new ChecklistSecurity());

        $inspection = $connInspectionDetail->where('id', $id)
            ->with(['Room', 'Schedule', 'Shift'])
            ->first();
            $inspection['status'] = json_decode($inspection->status);
            
            return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil history inspection Security'
        );
    }



}
