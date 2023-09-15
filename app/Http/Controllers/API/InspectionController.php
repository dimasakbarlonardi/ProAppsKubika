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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    public function checklistengineering(Request $request)
    {
        $connInspectionEng = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $inspection = $connInspectionEng->get();

        return ResponseFormatter::success([
            $inspection
        ], 'Berhasil mengambil Equiqment Engineering');
    }

    public function schedueinspection(Request $request)
    {
        $connInspectionEng = ConnectionDB::setConnection(new EquiqmentAhu());

        $inspection = $connInspectionEng->get();

        return ResponseFormatter::success([
            $inspection
        ], 'Berhasil mengambil Schedule Engineering');
    }

    public function storeinspectionEng(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        try {
            DB::beginTransaction();

            $create = $conn->create($request->all());
            $create->id_equiqment_engineering_detail = $request->id_equiqment_engineering_detail;
            $create->id_equiqment_engineering = $request->id_equiqment_engineering;
            $create->image = $request->image;
            $create->id_room = $request->id_room;   
            $create->status = $request->status;
            $create->id_equiqment = $request->id_equiqment;
            $create->id_role = $request->id_role;
            $create->tgl_checklist = $request->tgl_checklist;
            $create->time_checklist = $request->time_checklist;
            $create->keterangan = $request->keterangan;

            $create->save();
            DB::commit();
 
            return ResponseFormatter::success([
                $create
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
        $parameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $parameterEng = ConnectionDB::setConnection(new EngAHU());

        $equipment = $connEquipment->where('id_equiqment_engineering', $id)->first();

        if (!$equipment) {
            return ResponseFormatter::error('Data Equipment tidak ditemukan', 404);
        }

        $id_item = $equipment->id_equiqment_engineering;

        $parameters = $parameter->where('id_item', $id_item)->get();

        $checklistParameters = [];

        foreach ($parameters as $parameter) {
            $engAhu = $parameterEng->where('id_eng_ahu', $parameter->id_checklist)->get();
            $checklistParameters[] = $engAhu;
        }

        return ResponseFormatter::success([
            'equipment' => $equipment,
            'checklistParameters' => $checklistParameters,
        ], 'Berhasil mengambil Equipment dan Data Checklist Parameter');
    }

    // -----------HouseKeeping-------------

    public function checklisthousekeeping(Request $request)
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $inspection = $connInspectionHK->get();

        return ResponseFormatter::success([
            $inspection
        ], 'Berhasil mengambil Equiqment HouseKeeping');
    }

    public function schedueinspectionhk(Request $request)
    {
        $connInspectionHK = ConnectionDB::setConnection(new EquiqmentToilet());

        $inspection = $connInspectionHK->get();

        return ResponseFormatter::success([
            $inspection
        ], 'Berhasil mengambil Schedule HouseKeeping');
    }

    public function storeinspectionHK(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        try {
            DB::beginTransaction();

            $create = $conn->create($request->all());
            $create->id_equipment_housekeeping_detail = $request->id_equipment_housekeeping_detail;
            $create->id_equipment_housekeeping = $request->id_equipment_housekeeping;
            $create->image = $request->image;
            $create->id_room = $request->id_room;
            $create->status = $request->status;
            $create->id_equipment = $request->id_equipment;
            $create->id_role = $request->id_role;
            $create->tgl_checklist = $request->tgl_checklist;
            $create->time_checklist = $request->time_checklist;
            $create->keterangan = $request->keterangan;

            $create->save();
            DB::commit();

            return ResponseFormatter::success([
                $create
            ], 'Berhasil Inspection HouseKeeping');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Gagal Inspection HouseKeeping');
        }
    }

    public function showHousekeeping($id)
    {
        $connEquipment = ConnectionDB::setConnection(new EquiqmentToilet());
        $parameter =  ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $parameterHK = ConnectionDB::setConnection(new Toilet());

        $equipment = $connEquipment->where('id_equipment_housekeeping', $id)->first();

        if (!$equipment) {
            return ResponseFormatter::error('Data Equipment tidak ditemukan', 404);
        }

        $id_item = $equipment->id_equipment_housekeeping;

        $parameters = $parameter->where('id_item', $id_item)->get();

        $checklistParameters = [];

        foreach ($parameters as $parameter) {
            $HK = $parameterHK->where('id_hk_toilet', $parameter->id_checklist)->get();
            $checklistParameters[] = $HK;
        }

        return ResponseFormatter::success([
            'equipment' => $equipment,
            'checklistParameters' => $checklistParameters,
        ], 'Berhasil mengambil Equipment dan Data Checklist Parameter');
    }

    // -------------- Security ---------------
    
}
