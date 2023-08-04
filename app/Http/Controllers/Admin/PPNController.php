<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\PPN;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use RealRashid\SweetAlert\Facades\Alert;

class PPNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connPPN = ConnectionDB::setConnection(new PPN());

        $data['ppns'] = $connPPN->get();

        return view('AdminSite.PPN.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.PPN.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $connPPN = ConnectionDB::setConnection(new PPN());
        try {

            DB::beginTransaction();

            $connPPN->create([
                'id_ppn' => $request->id_ppn,
                'nama_ppn' => $request->nama_ppn,
                'biaya_procentage' => $request->biaya_procentage,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Menambahkan PPN');
            
            return redirect()->route('ppns.index');
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e);
            Alert::error('Gagal', 'Gagal Menambahkan PPN');

            return redirect()->route('ppns.index');
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
        $connPPN = ConnectionDB::setConnection(new PPN());

        $data['ppn'] = $connPPN->find($id);

        return view('AdminSite.PPN.edit', $data);
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
        $connPPN = ConnectionDB::setConnection(new PPN());

        $PPN = $connPPN->find($id);
        $PPN->update($request->all());
        
        Alert::success('Berhasil', 'Berhasil Mengupdate PPN');

        return redirect()->route('ppns.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $connPPN = ConnectionDB::setConnection(new PPN());
        $connPPN->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil Menghapus PPN');

        return redirect()->route('ppns.index');
    }
}
