<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Tower;
use App\Models\Site;


class TowerController extends Controller
{
    public function setConnection(Request $request)
    {
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $tower = new Tower();
        $tower->setConnection($conn);

        return $tower;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $conn = $this->setConnection($request);

        $data['towers'] = $conn->get();

        return view('AdminSite.Tower.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $data['sites'] = Site::all();

        return view('AdminSite.Tower.create');
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

            $user_id = $request->user()->id;
            $login = Login::where('id', $user_id)->with('site')->first();
            $site = $login->site->id_site;

            $count = $conn->count();
            $count += 1;
            if ($count < 10) {
                $count = '0' . $count;
            }

            $conn->create([
                'id_tower' => $count,
                'id_site' => $site,
                'nama_tower' => $request->nama_tower,
                'jumlah_lantai' => $request->jumlah_lantai,
                'jumlah_unit' => $request->jumlah_unit,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan tower');

            return redirect()->route('towers.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan tower');

            return redirect()->route('towers.index');
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
        $data['tower'] = $conn->where('id_tower', $id)->first();

        return view('AdminSite.Tower.edit', $data);
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

        $conn->where('id_tower', $id)->update([
            'nama_tower' => $request->nama_tower,
            'jumlah_lantai' => $request->jumlah_lantai,
            'jumlah_unit' => $request->jumlah_unit,
            'keterangan' => $request->keterangan,
        ]);

        Alert::success('Berhasil', 'Berhasil mengupdate tower');

        return redirect()->route('towers.index');
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
        $conn->where('id_tower', $id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus tower');

        return redirect()->route('towers.index');
    }
}
