<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\StatusTinggal;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class StatusTinggalController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new StatusTinggal();
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
        $data['statustinggals'] = $conn->get();

        return view('AdminSite.StatusTinggal.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.StatusTinggal.create');
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
                'id_status_tinggal' => $request->id_status_tinggal,
                'status_tinggal' => $request->status_tinggal
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan status tinggal');

            return redirect()->route('statustinggals.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan status tinggal');

            return redirect()->route('statustinggals.index');
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

        $data['statustinggal'] = $conn->find($id);

        return view('AdminSite.StatusTinggal.edit', $data);
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

        $statustinggal = $conn->find($id);
        $statustinggal->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate status tinggal');

        return redirect()->route('statustinggals.index');
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

            Alert::success('Berhasil', 'Berhasil menghapus status tinggal');

            return redirect()->route('statustinggals.index');
    }
}
