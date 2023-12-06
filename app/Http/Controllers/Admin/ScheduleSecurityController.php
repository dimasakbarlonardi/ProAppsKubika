<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\ParameterSecurity;
use App\Models\Room;
use App\Models\ScheduleSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ChecklistParameterEquiqment;
use App\Models\ChecklistSecurity;
use App\Models\ParameterShiftSecurity;
use App\Imports\ImportScheduleSecurity;
use Excel;

class ScheduleSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ScheduleSecurity());

        $data['schedulesec'] = $conn->get();
        $data['eq'] = $conn->first();

        return view('AdminSite.ScheduleSecurity.index', $data);
    }

    public function import(Request $request)
    {
        $file = $request->file('file_excel');

        Excel::import(new ImportScheduleSecurity(), $file);

        Alert::success('Success', 'Success import data');

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $room = ConnectionDB::setConnection(new Room());
        $parameter = ConnectionDB::setConnection(new ParameterSecurity());
        $shift = ConnectionDB::setConnection(new ParameterShiftSecurity());

        $data['rooms'] = $room->get();
        $data['shifts'] = $shift->get();
        $data['ParameterSecurity'] = $parameter->get();

        return view('AdminSite.ScheduleSecurity.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Simpan data ke dalam tabel ScheduleSecurity
            $schedule = ConnectionDB::setConnection(new ScheduleSecurity());
            $schedule->schedule = $request->schedule;
            $schedule->id_shift = $request->id_shift;
            $schedule->id_room = $request->id_room;
            $schedule->save();

            $connEquipmentDetail = ConnectionDB::setConnection(new ChecklistSecurity());

            $connEquipmentDetail->create([
                'id_parameter_security' => $schedule->id,
                'schedule' => $request->schedule,
                'id_room' => $request->id_room,
                'id_shift' => $request->id_shift,
                'status_schedule' => 'Not Done'
            ]);

            $parameter = $request->to;
            if (!empty($parameter)) {
                foreach ($parameter as $form) {

                    $Parameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
                    $Parameter->id_equiqment = 3;
                    $Parameter->id_checklist = $form;
                    $Parameter->id_item = $schedule->id;
                    $Parameter->save();
                }
            }

            DB::commit();

            Alert::success('Success', 'Successfully Added Schedule Security');

            return redirect()->route('schedulesecurity.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add Schedule Security');

            return redirect()->route('schedulesecurity.index');
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
        $conn = ConnectionDB::setConnection(new ScheduleSecurity());
        $parameter = ConnectionDB::setConnection(new ParameterSecurity());
        $connParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $inspectionParameter = ConnectionDB::setConnection(new ParameterSecurity());
        $room = ConnectionDB::setConnection(new Room());
        $shift = ConnectionDB::setConnection(new ParameterShiftSecurity());

        $data['checklistparameters'] = $connParameter
            ->where('id_equiqment', 3)
            ->where('id_item', $id)
            ->get();

        $data['parameters'] = $inspectionParameter->where('deleted_at', null)
            ->with(['Checklist' => function ($q) use ($id) {
                $q->where('id_item', $id);
            }])
            ->get();
        $data['id'] = $id;

        $data['ParameterSecurity'] = $parameter->where('id', $id)->first();
        $data['ScheduleSecurity'] = $conn->where('id', $id)->first();
        $data['rooms'] = $room->get();
        $data['shift'] = $shift->get();

        return view('AdminSite.ScheduleSecurity.show', $data);
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
        $conn = ConnectionDB::setConnection(new ScheduleSecurity());
        
        $checklistahu = $conn->find($id);
        $checklistahu->id_equiqment = 3;
        $checklistahu->id_room = $request->id_room;
        $checklistahu->save();
        
        $parameter = $request->to;
        if (!empty($parameter)) {
            foreach ($parameter as $form) {
                $Parameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        
                $existingParameter = $Parameter
                    ->where('id_equiqment', 3)
                    ->where('id_checklist', $form)
                    ->where('id_item', $checklistahu->id) // Menggunakan $checklistahu->id di sini
                    ->first();
        
                if ($existingParameter) {
                    // Memperbarui rekaman yang sudah ada
                    $existingParameter->update([
                        'id_equiqment' => 3,
                        'id_checklist' => $form,
                        'id_item' => $checklistahu->id, // Menggunakan $checklistahu->id di sini
                    ]);
                } else {
                    $Parameter->id_equiqment = 3;
                    $Parameter->id_checklist = $form;
                    $Parameter->id_item = $checklistahu->id; // Menggunakan $checklistahu->id di sini
                    $Parameter->save();
                }
            }
        }
        
        Alert::success('Berhasil', 'Berhasil mengupdate Security');
        
        return redirect()->route('schedulesecurity.index');
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
