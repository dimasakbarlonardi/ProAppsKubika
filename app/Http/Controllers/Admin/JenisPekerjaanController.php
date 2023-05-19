<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPekerjaan;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class JenisPekerjaanController extends Controller
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
        $connStatusRequest = $this->setConnection(new JenisPekerjaan());

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
        $connJenisPekerjaan = $this->setConnection(new JenisPekerjaan());

        try {
            DB::beginTransaction();

            $count = $connJenisPekerjaan->count();
            $count += 1;
   

            $connJenisPekerjaan->create([
                'id_jenis_pekerjaan' => $count,
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
        $connJenisPekerjaan = $this->setConnection(new JenisPekerjaan());
        $data['jenispekerjaan'] = $connJenisPekerjaan->where('id_jenis_pekerjaan', $id)->first();

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
        $connJenisPekerjaan = $this->setConnection(new JenisPekerjaan());
        $count = $connJenisPekerjaan->count();

        $connJenisPekerjaan->where('id_jenis_pekerjaan', $id)->update([
            'id_jenis_pekerjaan' => $count,
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
        $connJenisPekerjaan = $this->setConnection(new JenisPekerjaan());
        $connJenisPekerjaan->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus Jenis Pekerjaan');

        return redirect()->route('jenispekerjaans.index');
    }
}
