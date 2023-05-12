<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisKelamin;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class JenisKelaminController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $gender = new JenisKelamin();
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
        $data['genders'] = $conn->get();

        return view('AdminSite.JenisKelamin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('AdminSite.JenisKelamin.create');
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
                'id_jenis_kelamin' => $count,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan jenis kelamin');

            return redirect()->route('genders.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan jenis kelamin');

            return redirect()->route('genders.index');
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

        $data['gender'] = $conn->find($id);

        return view('AdminSite.JenisKelamin.edit', $data);
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

        Alert::success('Berhasil', 'Berhasil mengupdate jenis kelamin');

        return redirect()->route('genders.index');
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

        Alert::success('Berhasil', 'Berhasil menghapus jenis kelamin');

        return redirect()->route('genders.index');
    }
}
