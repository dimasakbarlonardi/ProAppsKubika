<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\IncidentalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;
use Throwable;

class IncidentalController extends Controller
{
    public function index()
    {
        $connIncident = ConnectionDB::setConnection(new IncidentalReport());

        $reports = $connIncident->where('deleted_at', null)
            ->with('Room')
            ->get();

        return ResponseFormatter::success(
            $reports,
            'Success get all reports'
        );
    }

    public function store(Request $request)
    {
        $id_site = $request->user()->id_site;
        $connIncident = ConnectionDB::setConnection(new IncidentalReport());

        try {
            DB::beginTransaction();

            $createReport = $connIncident->create($request->all());
            $createReport->incident_name = $request->incident_name;
            $createReport->room_id = $request->room_id;
            $createReport->incident_date = $request->incident_date;
            $createReport->incident_time = $request->incident_time;
            $createReport->desc = $request->desc;
            $createReport->save();

            $file = $request->file('incident_image');

            if ($file) {
                $fileName = $createReport->id . '-' .   $file->getClientOriginalName();
                $outputIncidentImage = '/public/' . $id_site . '/img/incidental_report/' . $fileName;
                $incidentImage = '/storage/' . $id_site . '/img/incidental_report/' . $fileName;

                Storage::disk('local')->put($outputIncidentImage, File::get($file));

                $createReport->incident_image = $incidentImage;
                $createReport->save();
            }

            DB::commit();

            return ResponseFormatter::success([
                $createReport
            ], 'Success create report');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return ResponseFormatter::error([
                'error' => $e,
            ], 'Failed to create report');
        }
    }

    public function show($id)
    {
        $connIncident = ConnectionDB::setConnection(new IncidentalReport());

        $reporst = $connIncident->where('id', $id)
            ->with('Room')
            ->get();

        return ResponseFormatter::success(
            $reporst,
            'Success get all reports'
        );
    }
}
