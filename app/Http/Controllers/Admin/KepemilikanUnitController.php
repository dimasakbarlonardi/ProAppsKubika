<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KepemilikanUnit;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class KepemilikanUnitController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new KepemilikanUnit();
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
        $data['kepemilikans'] = $conn->get();

        return view('AdminSite.KepemilikanUnit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;

        $owner = new OwnerH();
        $owner->setConnection($conn);

        $unit = new Unit();
        $unit->setConnection($conn);

        $data['kepemilikans'] = $owner->get();
        $data['units'] = $unit->get();

        return view('AdminSite.KepemilikanUnit.create', $data);
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

            // $count = $conn->count(); 
            // $count += 1;
            // if ($count < 10) {
            //     $count = '0' . $count;
            // }
            
            $conn->create([
                
                'id_pemilik' => $request->id_pemilik,
                'id_unit' => $request->id_unit,
                // 'id_status_hunian' => $request->id_status_hunian,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan kepemilikan unit');

            return redirect()->route('kepemilikans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan kepemilikan unggal');

            return redirect()->route('kepemilikans.index');
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

        $data['kepemilikan'] = $conn->find($id);

        return view('AdminSite.KepemilikanUnit.edit', $data);
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

        $kepemilikan = $conn->find($id);
        $kepemilikan->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate kepemilikan unit');

        return redirect()->route('kepemilikans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {
        $conn = $this->setConnection($request);
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus kepemiikan unit');

        return redirect()->route('kepemilikans.index');
    }
}
