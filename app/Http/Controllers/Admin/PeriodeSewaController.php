<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeSewa;
use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodeSewaController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new PeriodeSewa();
        $user->setConnection($conn);

        return $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = $this->setConnection($request);

        $data['sewas'] = $conn->get();

        return view('AdminSite.PeriodeSewa.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $total_unit = $this->setConnection($request);
        $total_unit = $total_unit->count();
        $total_unit += 1;
        $data['current_id'] = $total_unit;

        return view('AdminSite.PeriodeSewa.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $conn = $this->setConnection($request);

        try {
            DB::beginTransaction();

            $count = $conn->count(); 
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }
            
            $conn->create([
                'id_periode_sewa' => $count,
                'periode_sewa' => $request->periode_sewa,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Periode Sewa');

            return redirect()->route('sewas.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Periode Sewa');

            return redirect()->route('sewas.index');
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
    public function edit(Request $request,$id)
    {
        $conn = $this->setConnection($request);

        $data['sewa'] = $conn->find($id);

        return view('AdminSite.PeriodeSewa.edit', $data);
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
        $conn = $this->setConnection($request);

        $sewa = $conn->find($id);
        $sewa->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Periode Sewa');

        return redirect()->route('sewas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request,$id)
    {
        $conn = $this->setConnection($request);
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus Periode Sewa');

        return redirect()->route('sewas.index');
    }
}
