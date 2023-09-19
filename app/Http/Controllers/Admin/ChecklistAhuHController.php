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
use FTP\Connection;
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
        // $connahudetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $equiqment = ConnectionDB::setConnection(new EquiqmentAhu());
        $user_id = $request->user()->id;

        $data['checklistahus'] = $equiqment->get();
        // $data['ahudetails'] = $connahudetail->first();
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
        // $user_id = $request->user()->id;
        $data['checklistparameters'] = $connParameter->get();
        $data['parameters'] = $inspectionParameter->get();
        $data['id'] = $id;

        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistAhuH.checklist', $data);
    }

    public function checklistParameter(Request $request, $id)
    {
        $parameter = $request->to;
        $checklistParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $checklistahu = ConnectionDB::setConnection(new EquiqmentAhu());
        $equiqment = $checklistahu->where('id_equiqment_engineering', $id)->first();
        if (isset($parameter)) {
            foreach ($parameter as $form) {
                $checklistParameter->create([
                    'id_equiqment' => $id,
                    'id_checklist' => $form,
                    'id_item' => $equiqment->id_equiqment_engineering
                ]);

                $checklistParameter->save();
                DB::commit();
                Alert::success('Berhasil', 'Berhasil Menambahkan Inspection AHU');
            }
        }

        return redirect()->route('checklistahus.index');
    }

    // public function filterByNoChecklist(Request $request)
    // {
    //     $conn = ConnectionDB::setConnection(new ChecklistAhuH());


    //     if ($request->date_to == null) {
    //         $data = $conn->where('tgl_checklist', $request->date_from);
    //     } else {
    //         $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
    //     }

    //     if ($request->no_checklist_ahu) {
    //         $data = $data->where('no_checklist_ahu', $request->no_checklist_ahu);
    //     }
    //     $data = $data->get();

    //     return response()->json(['checklists' => $data]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
        try {
            DB::beginTransaction();

            $equiqmentAHU = ConnectionDB::setConnection(new EquiqmentAhu());

            $id_equiqment = 1;

            $equiqment = $equiqmentAHU->create([
                'no_equiqment' => $request->no_equiqment,
                'id_equiqment' => $id_equiqment,
                'equiqment' => $request->equiqment,
                'id_role' => $request->id_role,
                'id_room' => $request->id_room,
                'schedule' => $request->schedule,
                'set_schedule' => $request->set_schedule,
            ]);

            // Buat jadwal inspeksi berdasarkan set schedule yang dipilih
            $selectedSetSchedule = $request->set_schedule;
            $startDate = Carbon::parse($request->schedule);
            $endDate = $startDate->copy()->endOfYear(); // Akhir tahun

            $scheduleDates = [];
            $interval = ($selectedSetSchedule === 'weekly') ? '1 week' : '1 month';

            while ($startDate->lte($endDate)) {
                $scheduleDates[] = $startDate->format('Y-m-d');
                $startDate->add($interval);
            }

            // Simpan jadwal inspeksi ke dalam database
            foreach ($scheduleDates as $date) {
                $equiqment->inspections()->create([
                    'schedule_date' => $date,
                    'status_schedule' => 'Not Done', // Status awal
                ]);
            }

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Inspection AHU');

            return redirect()->route('checklistahus.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Gagal menambahkan Checklis AHU Detail');

            return redirect()->route('checklistahus.index');
        }
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
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $connroom = ConnectionDB::setConnection(new Room());
        $user_id = $request->user()->id;

        $data['checklistahu'] = $conn->where('no_checklist_ahu', $id)->first();
        $data['ahudetail'] = $conndetail->where('no_checklist_ahu', $id)->first();
        $data['rooms'] = $connroom->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

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
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());

        $checklistahu = $conn->find($id);
        $checklistahu->update($request->all());

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
}
