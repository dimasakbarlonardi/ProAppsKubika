<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\IncidentalReport;
use Illuminate\Http\Request;

class IncidentalReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new IncidentalReport());

        $data['incidental'] = $conn->get();

        return view('AdminSite.IncidentalReport.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = ConnectionDB::setConnection(new Room());

        $data['rooms'] = $room->get();

        return view('AdminSite.IncidentalReport.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new IncidentalReport());

        try {
            DB::beginTransaction();

            $data = [
                'incident_name' => $request->incident_name,
                'location' => $request->location,
                'incident_date' => $request->incident_date,
                'incident_time' => $request->incident_time,
                'desc' => $request->desc,
            ];

            if ($request->hasFile('incident_image')) {
                $image = $request->file('incident_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('incident_image'), $imageName);
                $data['incident_image'] = 'incident_image/' . $imageName;
            }

            $conn->create($data);

            DB::commit();

            Alert::success('Success', 'Successfully Added Report');

            return redirect()->route('incidentalreport.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Report');

            return redirect()->route('incidentalreport.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
