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
            ->with('Room')
            ->get();

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
            ->with(['InspectionEng.Checklist', 'Room'])
            ->first();

        return ResponseFormatter::success([
            'equipment' => $equipment
        ], 'Berhasil mengambil Equipment dan Data Checklist Parameter');
    }

    // -----------HouseKeeping-------------

    public function checklisthousekeeping(Request $request)
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $inspection = $connInspectionHK->where('deleted_at', null)
            ->with('Room')
            ->get();

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

    public function storeinspectionHK(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

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
            $conn->keterangan = $request->keterangan;

            $conn->save();
            DB::commit();

            return ResponseFormatter::success([
                $conn
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

        return ResponseFormatter::success([
            'equipment' => $equipment,
        ], 'Berhasil mengambil Equipment dan Data Checklist Parameter');
    }

    // -------------- Security ---------------
    
}
