<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAhuH;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistAhuDetail;
use App\Models\ChecklistParameterEquiqment;
use App\Models\EngAhu;
use App\Models\EquiqmentAhu;
use App\Models\EquiqmentEngineeringDetail;
use App\Models\InspectionEngineering;
use App\Models\Login;
use App\Models\Role;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


class ChecklistAhuHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $equiqment = ConnectionDB::setConnection(new EquiqmentAhu());
        $user_id = $request->user()->id;

        $data['checklistahus'] = $equiqment->get();
        $data['equiqments'] = $equiqment->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.index', $data);
    }

    public function front(Request $request)
    {
        $connahudetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $equiqment = ConnectionDB::setConnection(new EquiqmentAhu());
        $user_id = $request->user()->id;

        $data['checklistahus'] = $equiqment->get();
        $data['ahudetails'] = $connahudetail->first();
        $data['equiqments'] = $equiqment->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.front', $data);
    }

    public function checklist($id)
    {
        $connParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $inspectionParameter = ConnectionDB::setConnection(new EngAhu());

        $data['checklistparameters'] = $connParameter
            ->where('id_equiqment', 2)
            ->where('id_item', $id)
            ->get();

        $data['parameters'] = $inspectionParameter->where('deleted_at', null)
            ->with(['Checklist' => function ($q) use ($id) {
                $q->where('id_item', $id);
            }])
            ->get();
        $data['id'] = $id;

        return view('AdminSite.ChecklistAhuH.checklist', $data);
    }

    public function checklistParameter(Request $request, $id)
    {
        $parameter = $request->to;

        $checklistParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());

        $checklist_id = [];

        if ($parameter) {
            foreach ($parameter as $param) {
                $checklist_id[] = $param;
            }

            $deletes = $checklistParameter->where('id_equiqment', 2)
                ->where('id_item', $id)
                ->whereNotIn('id_checklist', $checklist_id)
                ->get();

            if (count($deletes) > 0) {
                $checklistParameter->where('id_equiqment', 2)
                    ->where('id_item', $id)
                    ->whereNotIn('id_checklist', $checklist_id)
                    ->delete();
            }

            if (isset($parameter)) {
                foreach ($parameter as $param) {
                    $checkParam = $checklistParameter->where('id_item', $id)
                        ->where('id_equiqment', 2)
                        ->where('id_checklist', $param)
                        ->first();

                    if (!$checkParam) {
                        $checklistParameter->create([
                            'id_equiqment' => 2,
                            'id_checklist' => $param,
                            'id_item' => $id
                        ]);
                    }
                }
            }
        } else {
            $checklistParameter->where('id_equiqment', 2)
                ->where('id_item', $id)
                ->delete();
        }

        Alert::success('Success', 'Success update Inspection Engineering');
        return redirect()->back();
    }

    public function create(Request $request)
    {
        $connroom = ConnectionDB::setConnection(new Room());
        $connahu = ConnectionDB::setConnection(new EngAhu());
        $role = ConnectionDB::setConnection(new Role());
        $user_id = $request->user()->id;

        $data['rooms'] = $connroom->get();
        $data['engahus'] = $connahu->get();
        $data['role'] = $role->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.create', $data);
    }

    public function add(Request $request)
    {
        $connroom = ConnectionDB::setConnection(new Room());
        $connahu = ConnectionDB::setConnection(new EngAhu());
        $role = ConnectionDB::setConnection(new Role());
        $user_id = $request->user()->id;

        $data['rooms'] = $connroom->get();
        $data['engahus'] = $connahu->get();
        $data['role'] = $role->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.add', $data);
    }

    public function inspectionStore(Request $request)
    {
        try {

            DB::beginTransaction();

            $inspectionEngineering = ConnectionDB::setConnection(new InspectionEngineering());

            $inspectionEngineering->create([
                'id_inspection_engineering' => $request->id_inspection_engineering,
                'inspection_engineering' => $request->inspection_engineering,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Inspection Engineering');

            return redirect()->route('checklistahus.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis AHU');

            return redirect()->route('checklistahus.index');
        }
    }


    public function store(Request $request)
    {
        $equiqmentAHU = ConnectionDB::setConnection(new EquiqmentAhu());

        try {
            DB::beginTransaction();

            $id_equiqment = 1;

            $equiqmentAHU->create([
                'no_equiqment' => $request->no_equiqment,
                'id_equiqment' => $id_equiqment,
                'equiqment' => $request->equiqment,
                'id_role' => $request->id_role,
                'id_room' => $request->id_room,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Inspection Engineering');

            return redirect()->route('checklistahus.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Inspection Engineering');

            return redirect()->route('checklistahus.index');
        }
    }

    public function updateSchedules(Request $request, $id)
    {
        $equiqmentDetail = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $schedule = $equiqmentDetail->find($id);

        $schedule->update($request->all());

        Alert::success('Success', 'Success update schedule');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new EquiqmentAhu());
        $equiqmentDetail = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $checklist = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $parameter = ConnectionDB::setConnection(new EngAhu());
        $user_id = $request->user()->id;

        $data['checklistahu'] = $conn->where('id_equiqment_engineering', $id)->first();
        $data['equiqmentdetail'] = $equiqmentDetail->where('id_equiqment_engineering', $id)->first();
        $data['parameters'] = $checklist->where('id_equiqment', $equiqmentDetail)->get();

        $data['idusers'] = Login::where('id', $user_id)->get();
        return view('AdminSite.ChecklistAhuH.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $connequiqment = ConnectionDB::setConnection(new EquiqmentAhu());
        $connroom = ConnectionDB::setConnection(new Room());

        $data['equipmentengineering'] = $connequiqment->where('id_equiqment_engineering', $id)->first();
        $data['rooms'] = $connroom->get();

        return view('AdminSite.ChecklistAhuH.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EquiqmentAhu());

        $checklistahu = $conn->find($id);
        $checklistahu->no_equiqment = $request->no_equipment;
        $checklistahu->equiqment = $request->equipment;
        $checklistahu->id_room = $request->id_room;
        $checklistahu->save();

        Alert::success('Berhasil', 'Berhasil mengupdate Checklis AHU');

        return redirect()->route('checklistahus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());

        $conn->find($id)->delete();
        Alert::success('Berhasil', 'Berhasil Menghapus Checklist AHU');

        return redirect()->route('checklistahus.index');
    }

    public function inspectionSchedules($id)
    {
        $connEquiqment = ConnectionDB::setConnection(new EquiqmentAhu());
        $connSchedules = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $data['eq'] = $connEquiqment->find($id);
        $data['schedules'] = $connSchedules->where('id_equiqment_engineering', $id)
            ->orderBy('schedule', 'ASC')
            ->get();

        return view('AdminSite.ChecklistAhuH.schedules', $data);
    }

    public function postSchedules(Request $request, $id)
    {
        $connEquipmentDetail = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $connEquipmentDetail->create([
            'id_equiqment_engineering' => $id,
            'schedule' => $request->schedule,
            'status_schedule' => 'Not Done'
        ]);

        Alert::success('Success', 'Success add schedule');

        return redirect()->back();
    }

    public function destroySchedules($id)
    {
        $connSchedules = ConnectionDB::setConnection(new EquiqmentEngineeringDetail());

        $schedule = $connSchedules->find($id);
        $schedule->delete();

        Alert::success('Success', 'Success remove schedule');

        return redirect()->back();
    }
}
