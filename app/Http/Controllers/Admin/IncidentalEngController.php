<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\IncidentalReportEng;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class IncidentalEngController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new IncidentalReportEng());
        $connroom = ConnectionDB::setConnection(new Room());

        $data['incidentalengs'] = $conn->get();
        $data['rooms'] = $connroom->get();

        return view('AdminSite.IncidentalEng.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conn = ConnectionDB::setConnection(new IncidentalReportEng());
        $connroom = ConnectionDB::setConnection(new Room());

        $data['incidentalengs'] = $conn->get();
        $data['rooms'] = $connroom->get();

        return view('AdminSite.IncidentalEng.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new IncidentalReportEng());

        try {
            DB::beginTransaction();

            $data = [
                'reported_name' => $request->reported_name,
                'incident_name' => $request->incident_name,
                'id_room' => $request->id_room,
                'date' => $request->date,
                'time' => $request->time,
                'keterangan' => $request->keterangan,
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data['image'] = 'images/' . $imageName;
            }

            $conn->create($data);

            DB::commit();

            Alert::success('Success', 'Successfully Added Report');

            return redirect()->route('incidentalreporteng.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Report');

            return redirect()->route('incidentalreporteng.index');
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
