<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\JenisKendaraan;
use Illuminate\Http\Request;

class JenisKendaraanController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $jeniskendaraan = new JenisKendaraan();
        $jeniskendaraan->setConnection($conn);

        return $jeniskendaraan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = $this->setConnection($request);
        $data['jeniskendaraans'] = $conn->get();

        return view('AdminSite.JenisKendaraan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.JenisKendaraan.create');
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
                'id_jenis_kendaraan' => $count,
                'jenis_kendaraan' => $request->jenis_kendaraan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan jenis kendaraan');

            return redirect()->route('jeniskendaraans.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan jenis kendaraan');

            return redirect()->route('jeniskendaraans.index');
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
    public function edit(Request $request ,$id)
    {
        $conn = $this->setConnection($request);

        $data['jeniskendaraan'] = $conn->where('id_jenis_kendaraan',$id)->first();

        return view('AdminSite.JenisKendaraan.edit', $data);
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

        $jeniskendaraan = $conn->find($id);
        $jeniskendaraan->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate jenis kendaraan');

        return redirect()->route('jeniskendaraans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        $conn = $this->setConnection($request);
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus jenis kendaraan');

        return redirect()->route('jeniskendaraans.index');
    }
}
