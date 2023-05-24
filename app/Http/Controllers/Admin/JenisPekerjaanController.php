<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\JenisPekerjaan;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class JenisPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connStatusRequest = ConnectionDB::setConnection(new JenisPekerjaan());

        $data['jenispekerjaans'] = $connStatusRequest->get();

        return view('AdminSite.JenisPekerjaan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.JenisPekerjaan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connJenisPekerjaan = ConnectionDB::setConnection(new JenisPekerjaan());

        try {
            DB::beginTransaction();

            $connJenisPekerjaan->create([
                'jenis_pekerjaan' => $request->jenis_pekerjaan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Jenis Pekerjaan');

            return redirect()->route('jenispekerjaans.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Jenis Pekerjaan');

            return redirect()->route('jenispekerjaans.index');
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
        $connJenisPekerjaan = ConnectionDB::setConnection(new JenisPekerjaan());

        $data['jenispekerjaan'] = $connJenisPekerjaan->find($id);

        return view('AdminSite.JenisPekerjaan.edit', $data);
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
        $connJenisPekerjaan = ConnectionDB::setConnection(new JenisPekerjaan());

        $connJenisPekerjaan->where('id_jenis_pekerjaan', $id)->update([
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
        ]);

        Alert::success('Berhasil', 'Berhasil Mengupdate Jenis Pekerjaan');

        return redirect()->route('jenispekerjaans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $connJenisPekerjaan = ConnectionDB::setConnection(new JenisPekerjaan());
        $connJenisPekerjaan->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Jenis Pekerjaan');

        return redirect()->route('jenispekerjaans.index');
    }
}
