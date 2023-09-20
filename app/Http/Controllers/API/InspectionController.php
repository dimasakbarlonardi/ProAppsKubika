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

class InspectionController extends Controller
{
    public function checklistengineering(Request $request)
    {
        $connInspectionEng = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $inspection = $connInspectionEng->where('deleted_at', null)
            ->with(['Room', 'equipment', 'Schedule'])
            ->get();

        foreach ($inspection as $key => $data) {
            $inspection[$key]['status'] = json_decode($data->status);
        }

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Equiqment Engineering'
        );
    }

    public function schedueinspection(Request $request)
    {
        $connInspectionEng = ConnectionDB::setConnection(new EquiqmentAhu());

        $inspection = $connInspectionEng->where('deleted_at', null)->with('Room')->get();

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Schedule Engineering'
        );
    }

    public function storeinspectionEng(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());
        $connSchedule = ConnectionDB::setConnection(new EquiqmentAhu());

        try {
            DB::beginTransaction();

            $conn->id_equiqment_engineering = $request->id_equiqment_engineering;
            $file = $request->file('image');

            if ($file) {
                $fileName = $request->id_equiqment_engineering . '-' .   $file->getClientOriginalName();
                $outputInspecImage = '/public/' . $request->user()->id_site . '/img/inspection/eng/' . $fileName;
                $inspecImage = '/storage/' . $request->user()->id_site . '/img/inspection/eng/' . $fileName;

                Storage::disk('local')->put($outputInspecImage, File::get($file));

                $conn->image = $inspecImage;
            }
            $conn->status = json_encode($request->status);
            $conn->id_room = $request->id_room;
            $conn->id_equiqment = $request->id_equiqment;
            $conn->id_role = $request->id_role;
            $conn->tgl_checklist = Carbon::now()->format('Y-m-d');
            $conn->time_checklist = Carbon::now()->format('H:i');
            $conn->keterangan = $request->keterangan;

            $conn->save();
            DB::commit();

            $equiqmentEngineeringId = $conn->id_equiqment_engineering;
            $schedule = $connSchedule->where('id_equiqment_engineering', $equiqmentEngineeringId)->first();

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
                $conn
            ], 'Berhasil Inspection Engineering');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
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
            ->with(['Room', 'Equipment', 'Role'])
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

        $inspection = $connInspectionHK->where('deleted_at', null)
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

    public function schedueinspectionhk(Request $request)
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquiqmentToilet());

        $inspection = $connInspectionHK->where('deleted_at', null)
            ->with('Room')
            ->get();

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil Schedule HouseKeeping'
        );
    }

    public function storeinspectionHK(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());
        $connSchedule = ConnectionDB::setConnection(new EquiqmentToilet());

        try {
            DB::beginTransaction();

            $conn->id_equipment_housekeeping = $request->id_equipment_housekeeping;
            $file = $request->file('image');

            if ($file) {
                $fileName = $request->id_equipment_housekeeping . '-' .   $file->getClientOriginalName();
                $outputInspecImage = '/public/' . $request->user()->id_site . '/img/inspection/hk/' . $fileName;
                $inspecImage = '/storage/' . $request->user()->id_site . '/img/inspection/hk/' . $fileName;

                Storage::disk('local')->put($outputInspecImage, File::get($file));

                $conn->image = $inspecImage;
            }
            $conn->id_room = $request->id_room;
            $conn->status = json_encode($request->status);
            $conn->id_equipment = $request->id_equipment;
            $conn->id_role = $request->id_role;
            $conn->tgl_checklist = Carbon::now()->format('Y-m-d');
            $conn->time_checklist = Carbon::now()->format('H:i');
            $conn->id_equipment_housekeeping = $id;
            $conn->keterangan = $request->keterangan;

            $conn->save();
            DB::commit();

            $schedule = $connSchedule->find($id);

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
                $conn
            ], 'Berhasil Inspection Engineering');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal Inspection Engineering');
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
            ->with(['Room', 'Equipment', 'Role', 'Schedule'])
            ->first();

        $inspection['status'] = json_decode($inspection->status);

        return ResponseFormatter::success(
            $inspection,
            'Berhasil mengambil history inspection HK'
        );
    }

    // ------------ end inspection -----------------

}
