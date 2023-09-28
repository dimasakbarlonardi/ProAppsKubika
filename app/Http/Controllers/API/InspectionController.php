<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ChecklistParameterEquiqment;
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
            ->with('Equipment.Room')
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
            $schedule->status = json_encode($request->status);
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
        $connEquipment = ConnectionDB::setConnection(new EquiqmentAhu());

        $equipment = $connEquipment->where('id_equiqment_engineering', $id)
            ->with('Room')
            ->first();

        $checklist = [];
        foreach ($equipment->InspectionEng as $key => $data) {
            $checklist[$key]['checklist'] = $data->Checklist->nama_eng_ahu;
        }

        return ResponseFormatter::success([
            'equipment' => $equipment,
            'question' => $checklist
        ], 'Berhasil mengambil Equipment dan Data Checklist Parameter');
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
            ->with(['Room', 'Schedule', 'equipment'])
            ->get();

        foreach ($inspection as $key => $data) {
            $inspection[$key]['status'] = json_decode($data->status);
        }

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Equiqment HouseKeeping'
        );
    }

    public function schedueinspectionhk()
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $nowMonth = Carbon::now()->format('m');
        $getSchedules = $connInspectionHK->whereMonth('schedule', $nowMonth)
            ->where('status_schedule', 'Not Done')
            ->with('Equipment.Room')
            ->get();

        $inspections = [];

        if ($getSchedules) {
            foreach ($getSchedules as $schedule) {
                $eq = $schedule->Equipment;

                $object = new stdClass();
                $object->id_equipment_housekeeping = $schedule->id_equipment_housekeeping_detail;
                $object->schedule = $schedule->schedule;
                $object->equipment = $eq->equiqment;
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
            $schedule->status = json_encode($request->status);
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
        $connEquipment = ConnectionDB::setConnection(new EquiqmentToilet());

        $equipment = $connEquipment->where('id_equipment_housekeeping', $id)
            ->with(['Inspection.ChecklistHK', 'Room'])
            ->first();

        $checklist = [];
        foreach ($equipment->Inspection as $key => $data) {
            $checklist[$key]['checklist'] = $data->ChecklistHK->nama_hk_toilet;
        }

        return ResponseFormatter::success([
            'equipment' => $equipment,
            'question' => $checklist
        ], 'Berhasil mengambil Equipment dan Data Checklist Parameter');
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

}
