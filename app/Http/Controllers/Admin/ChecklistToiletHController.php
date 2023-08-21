<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistParameterEquiqment;
use App\Models\ChecklistToiletDetail;
use App\Models\ChecklistToiletH;
use App\Models\EquiqmentToilet;
use App\Models\Login;
use App\Models\Role;
use App\Models\Room;
use App\Models\Toilet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ChecklistToiletHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conntoiletdetail = ConnectionDB::setConnection(new ChecklistToiletDetail());
        $equiqment = ConnectionDB::setConnection(new EquiqmentToilet());
        $user_id = $request->user()->id;

        $data['checklisttoilets'] = $equiqment->get();
        $data['toiletdetail'] = $conntoiletdetail->first();
        $data['equiqments'] = $equiqment->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistToiletH.index', $data);
    }

    public function fronttoilet(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());
        $conntoiletdetail = ConnectionDB::setConnection(new ChecklistToiletDetail());
        $equiqment = ConnectionDB::setConnection(new EquiqmentToilet());
        $user_id = $request->user()->id;    

        $data['checklisttoilets'] = $conn->get();
        $data['toiletdetails'] = $conntoiletdetail->first();
        $data['equiqments'] = $equiqment->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistToiletH.front', $data);
    }

    public function checklist($id)
    {
        $connParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $inspectionParameter = ConnectionDB::setConnection(new Toilet());
        // $user_id = $request->user()->id;
        $data['checklistparameters'] = $connParameter->get();
        $data['parameters'] = $inspectionParameter->get();
        $data['id'] = $id;

        // $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistToiletH.checklist', $data);
    }

    public function checklistParameter(Request $request, $id)
    {
    $parameter = $request->to;
    $checklistParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
    $idhktoilet = ConnectionDB::setConnection(new ChecklistToiletDetail());

    if (isset($parameter)) {
        foreach ($parameter as $form) {
            $checklistParameter->create([
                'id_equiqment'=>$id,
                'id_checklist'=>$form
            ]);
            dd($id,$form);
            DB::commit();

            Alert::success('Berhasil', 'Berhasil Menambahkan Inspection Toilet');
        }
       
        }

    return redirect()->route('checklisttoilets.index');
    }

    public function filterByNoChecklist(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());

        if ($request->date_to == null) {
            $data = $conn->where('tgl_checklist', $request->date_from);
        } else {
            $data = $conn->whereBetween('tgl_checklist', [$request->date_from, $request->date_to]);
        }

        if ($request->no_checklist_toilet) {
            $data = $data->where('no_checklist_toilet', $request->no_checklist_toilet);
        }
        $data = $data->get();

        return response()->json(['checklists' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $connroom = ConnectionDB::setConnection(new Room());
        $conntoilet = ConnectionDB::setConnection(new Toilet());
        $role = ConnectionDB::setConnection(new Role());

        $data['rooms'] = $connroom->get();
        $data['engtoilets'] = $conntoilet->get();
        $data['role'] = $role->get();

        return view('AdminSite.ChecklistToiletH.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());
        $conndetail = ConnectionDB::setConnection(new ChecklistToiletDetail());

        try {

            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();

            $toilet = ConnectionDB::setConnection(new Toilet());

            $equiqmentTOILET = ConnectionDB::setConnection(new EquiqmentToilet());

            $id_toilet = $toilet->first('id_hk_toilet');

            $today = Carbon::now()->format('dmY');

            $tgl = Carbon::now()->format('y-m-d');

            $current = Carbon::now()->format('hi');

            $time = Carbon::now()->format('his');

            $no_checklist_toilet = $id_toilet->id_hk_toilet . $today . $current;


            // $conn->create([
            //     'id_eng_checklist_toilet' => $request->id_eng_checklist_toilet,
            //     'barcode_room' => $request->barcode_room,
            //     'id_room' => $request->id_room,
            //     'tgl_checklist' => $tgl,
            //     'time_checklist' => $time,
            //     'id_user' => $id_user,
            //     'no_checklist_toilet' => $no_checklist_toilet
            // ]);

            // $conndetail->create([
            //     'id_eng_toilet' => $request->count,
            //     'no_checklist_toilet' => $no_checklist_toilet,
            //     'check_point' => $request->check_point,
            //     'keterangan' => $request->keterangan,
            // ]);

            $equiqmentTOILET->create([
                'no_equiqment' => $request->no_equiqment,
                'equiqment' => $request->equiqment,
                'id_role' => $request->id_role,
                'id_room' => $request->id_room,
                'senin' => $request->senin,
                'selasa' => $request->selasa,
                'rabu' => $request->rabu,
                'kamis' => $request->kamis,
                'jumat' => $request->jumat,
                'sabtu' => $request->sabtu,
                'minggu' => $request->minggu,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Checklis toilet');

            return redirect()->route('checklisttoilets.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Checklis toilet');

            return redirect()->route('checklisttoilets.index');
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
        $conn = ConnectionDB::setConnection(new ChecklistToiletH());
        $conndetail = ConnectionDB::setConnection(new ChecklistToiletDetail());
        $parameter = ConnectionDB::setConnection(new Toilet());
        $checklist= ConnectionDB::setConnection(new ChecklistParameterEquiqment());
        $user_id = $request->user()->id;

        $data['checklisttoilet'] = $conn->where('no_checklist_toilet', $id)->first();
        $data['toiletdetail'] = $conndetail->where('no_checklist_toilet', $id)->first();
        $data['parameters'] = $parameter->get();
        $data['idusers'] =  Login::where('id', $user_id)->get();

        return view('AdminSite.ChecklistToiletH.show', $data);
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
