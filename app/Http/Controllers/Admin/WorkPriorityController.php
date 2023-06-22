<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkPriority;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class WorkPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new WorkPriority());

        $data['workprioritys'] = $conn->get();

        return view('AdminSite.WorkPriority.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.WorkPriority.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new WorkPriority());

        try {
            DB::beginTransaction();   

            $conn->create([
                'id_work_priority' => $request->id_work_priority,
                'work_priority' => $request->work_priority,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan work priority');

            return redirect()->route('workprioritys.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan work priority');

            return redirect()->route('workprioritys.index');
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
        $connWorkPriority = ConnectionDB::setConnection(new WorkPriority());

        $data['workpriority'] = $connWorkPriority->where('id_work_priority', $id)->first();

        return view('AdminSite.WorkPriority.edit', $data);
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
        $connWorkPriority = ConnectionDB::setConnection(new WorkPriority());

        $connWorkPriority = $connWorkPriority->find($id);
        $connWorkPriority->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Work Priority');

        return redirect()->route('workprioritys.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $connWorkPriority = ConnectionDB::setConnection(new WorkPriority());
        $connWorkPriority->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Work Priority');

        return redirect()->route('workprioritys.index');
    }
}
