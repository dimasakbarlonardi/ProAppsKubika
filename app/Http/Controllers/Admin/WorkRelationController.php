<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\WorkRelation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class WorkRelationController extends Controller
{
    public function setConnection($model)
    {
        $request = Request();
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $model = $model;
        $model->setConnection($conn);

        return $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connWorkRelation = $this->setConnection(new WorkRelation());

        $data['workrelations'] = $connWorkRelation->get();

        return view('AdminSite.WorkRelation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.WorkRelation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connWorkRelation = $this->setConnection(new WorkRelation());

        try {
            DB::beginTransaction();

            $count = $connWorkRelation->count();
            $count += 1;
   

            $connWorkRelation->create([
                'id_work_relation' => $count,
                'work_relation' => $request->work_relation,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan work relation');

            return redirect()->route('workrelations.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan work relation');

            return redirect()->route('workrelations.index');
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
        $connWorkRelation = $this->setConnection(new WorkRelation());

        $data['workrelation'] = $connWorkRelation->where('id_work_relation', $id)->first();

        return view('AdminSite.WorkRelation.edit', $data);
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
        $connWorkRelation = $this->setConnection(new WorkRelation());
        $count = $connWorkRelation->count();

        $connWorkRelation->where('id_work_relation', $id)->update([
            'id_work_relation' => $count,
            'work_relation' => $request->work_relation,
        ]);

        Alert::success('Berhasil', 'Berhasil Mengupdate Work Relation');

        return redirect()->route('workrelations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $connWorkRelation = $this->setConnection(new WorkRelation());
        $connWorkRelation->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Work Relation');

        return redirect()->route('workrelations.index');
    }
}