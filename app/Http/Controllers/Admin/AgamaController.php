<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $gender = new Agama();
        $gender->setConnection($conn);

        return $gender;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = $this->setConnection($request);
        $data['agamas'] = $conn->get();

        return view('AdminSite.Agama.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Agama.create');
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
                'id_agama' => $count,
                'nama_agama' => $request->nama_agama,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan agama');

            return redirect()->route('agamas.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan agama');

            return redirect()->route('agamas.index');
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
    public function edit(Request $request, $id)
    {
        $conn = $this->setConnection($request);

        $data['agama'] = $conn->find($id);

        return view('AdminSite.Agama.edit', $data);
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

        $gender = $conn->find($id);
        $gender->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate agama');

        return redirect()->route('agamas.index');
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

        Alert::success('Berhasil', 'Berhasil menghapus agama');

        return redirect()->route('agamas.index');
    }
}
