<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Pengurus;
use Illuminate\Support\Facades\DB;
use Throwable;


class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['penguruses'] = Pengurus::with('group')->get();

        return view('Admin.Pengurus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['groups'] = Group::all();

        return view('Admin.Pengurus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pengurus' => 'required|unique:penguruses,id_pengurus'
        ]);

        try {
            DB::beginTransaction();

            Pengurus::create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan site');

            return redirect()->route('penguruses.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
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
    public function edit(Pengurus $pengurus)
    {
        $data['pengurus'] = $pengurus;
        $data['groups'] = Group::all();

        return view('Admin.pengurus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        try {
            DB::beginTransaction();

            $pengurus->update($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil mengubah pengurus');

            return redirect()->route('penguruses.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengurus $pengurus)
    {
        $pengurus->delete();

        Alert::success('Berhasil', 'Berhasil mengubah pengurus');

        return redirect()->route('penguruses.index');
    }
}
