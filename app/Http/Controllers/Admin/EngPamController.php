<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EngPAM;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\ConnectionDB;
use Illuminate\Http\Request;

class EngPamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $conn = ConnectionDB::setConnection(new EngPAM());

        $data ['engpams'] = $conn->get();

        return view('AdminSite.EngPAM.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.EngPAM.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new EngPAM());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_eng_pam' => $request->id_eng_pam,
                'nama_eng_pam' => $request->nama_eng_pam,
                'subject' => $request->subject,
                'dsg' => $request->dsg,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Engeneering PAM');

            return redirect()->route('engpams.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Engeneering PAM');

            return redirect()->route('engpams.index');
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
        $conn = ConnectionDB::setConnection(new EngPAM());

        $data['engpam'] = $conn->find($id);

        return view('AdminSite.EngPAM.edit', $data);
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
        $conn = ConnectionDB::setConnection(new EngPAM());

        $engpam = $conn->find($id);
        $engpam->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Engeneering PAM');

        return redirect()->route('engpams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new EngPAM());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Engeneering PAM');

        return redirect()->route('engpams.index');
    }
}
