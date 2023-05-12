<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\Login;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class FloorController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new Floor();
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

        $data['floors'] = $conn->get();

        return view('AdminSite.Floor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Floor.create');
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
                'id_lantai' => $count,
                'nama_lantai' => $request->nama_lantai,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Lantai');

            return redirect()->route('floors.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan lantai');

            return redirect()->route('floors.index');
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

        $data['floor'] = $conn->find($id);

        return view('AdminSite.Floor.edit', $data);
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

        $floor = $conn->find($id);
        $floor->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate lantai');

        return redirect()->route('floors.index');
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

        Alert::success('Berhasil', 'Berhasil menghapus lantai');

        return redirect()->route('floors.index');
    }
}
