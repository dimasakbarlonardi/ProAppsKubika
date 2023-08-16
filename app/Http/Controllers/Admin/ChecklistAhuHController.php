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
        $connahudetail = ConnectionDB::setConnection(new ChecklistAhuDetail());
        $equiqment = ConnectionDB::setConnection(new EquiqmentAhu());
        $user_id = $request->user()->id;

        $data['checklistahus'] = $equiqment->get();
        $data['ahudetails'] = $connahudetail->first();
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

        if (isset($parameter)) {
            foreach ($parameter as $form) {
                $checklistParameter->create([
                    'id_equiqment' => $id,
                    'id_checklist' => $form
                ]);

                DB::commit();

                Alert::success('Berhasil', 'Berhasil Menambahkan Inspection AHU');
            }
        }

        return redirect()->route('checklistahus.index');
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());


        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_ahu) {
            $data = $data->where('no_checklist_ahu', $request->no_checklist_ahu);
        }
        $data = $data->get();

        return response()->json(['checklists' => $data]);
    }

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
        $conn = ConnectionDB::setConnection(new ChecklistAhuH());
        $conndetail = ConnectionDB::setConnection(new ChecklistAhuDetail());

        try {

            DB::beginTransaction();

            $ahu = ConnectionDB::setConnection(new EngAhu());

            $equiqmentAHU = ConnectionDB::setConnection(new EquiqmentAhu());

            $idInspection = $equiqmentAHU->first('id_inspection_engineering');

            $id_ahu = $ahu->first('id_eng_ahu');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('Y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_ahu = $id_ahu->id_eng_ahu . $today . $current;

            dd($idInspection);

            // $conn->create([
            //     'id_checklist_ahu_h' => $request->id_checklist_ahu_h,
            //     'barcode_room' => $request->barcode_room,
            //     'id_room' => $request->id_room,
            //     'tgl_checklist' => $tgl,
            //     'time_checklist' => $time,
            //     // 'id_user' => $request->id_user,
            //     'no_checklist_ahu' => $no_checklist_ahu,
            // ]);

            // $conndetail->create([
            //     'id_ahu' => $request->id_ahu,
            //     'no_checklist_ahu' => $no_checklist_ahu,
            //     'in_out' => $request->in_out,
            //     'check_point' => $request->check_point,
            //     'keterangan' => $request->keterangan,
            // ]);

            $equiqmentAHU->create([
                'no_equiqment' => $request->no_equiqment,
                'equiqment' => $request->equiqment,
                'id_inspection_engineering' => $idInspection,
                'id_role' => $request->id_role,
                'id_room' => $request->id_room,
                'januari' => $request->januari,
                'febuari' => $request->febuari,
                'maret' => $request->maret,
                'april' => $request->april,
                'mei' => $request->mei,
                'juni' => $request->juni,
                'juli' => $request->juli,
                'agustus' => $request->agustus,
                'september' => $request->september,
                'oktober' => $request->oktober,
                'november' => $request->november,
                'december' => $request->december
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Inspection AHU');

            return redirect()->route('checklistahus.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis AHU');

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
