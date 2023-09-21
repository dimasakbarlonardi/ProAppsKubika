<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ConnectionDB;
use App\Models\ChecklistParameterEquiqment;
use App\Models\ChecklistToiletDetail;
use App\Models\ChecklistToiletH;
use App\Models\EquipmentHousekeepingDetail;
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
        $equiqment = ConnectionDB::setConnection(new EquiqmentToilet());
        $user_id = $request->user()->id;

        $data['checklisttoilets'] = $equiqment->get();
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

    public function checklisttoilet($id)
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

    public function checklistParameterHK(Request $request, $id)
    {
    $parameter = $request->to;
    $checklistParameter = ConnectionDB::setConnection(new ChecklistParameterEquiqment());
    $checklistahu = ConnectionDB::setConnection(new EquiqmentToilet());
    $equipment = $checklistahu->where('id_equipment_housekeeping', $id)->first();

    if (isset($parameter)) {
        foreach ($parameter as $form) {
            $checklistParameter->create([
                'id_equiqment'=>$id,
                'id_checklist'=>$form,
                'id_item'=>$equipment->id_equipment_housekeeping
            ]);
            DB::commit();

            Alert::success('Berhasil', 'Berhasil Menambahkan Inspection Toilet');
        }

        }

    return redirect()->route('checklisttoilets.index');
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
        try {
            DB::beginTransaction();

            $equiqmentHK = ConnectionDB::setConnection(new EquiqmentToilet());

            $id_equiqment = 2;

            $equiqment = $equiqmentHK->create([
                'no_equipment' => $request->no_equipment,
                'id_equiqment' => $id_equiqment,
                'equipment' => $request->equipment,
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

            Alert::success('Berhasil', 'Berhasil menambahkan Inspection HK');

            return redirect()->route('checklisttoilets.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Gagal menambahkan Inspection HK');

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

    public function inspectionSchedulesHK($id)
    {
        $connEquiqment = ConnectionDB::setConnection(new EquiqmentToilet());
        $connSchedules = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $data['eq'] = $connEquiqment->find($id);
        $data['schedules'] = $connSchedules->where('id_equipment_housekeeping', $id)
        ->orderBy('schedule', 'ASC')
        ->get();

        return view('AdminSite.ChecklistToiletH.schedules', $data);
    }

    public function postSchedulesHK(Request $request, $id)
    {
        $connEquipmentDetail = ConnectionDB::setConnection(new EquipmentHousekeepingDetail());

        $connEquipmentDetail->create([
            'id_equipment_housekeeping' => $id,
            'schedule' => $request->schedule,
            'status_schedule' => 'Not Done'
        ]);

        Alert::success('Success', 'Success add schedule');

        return redirect()->back();
    }
}
