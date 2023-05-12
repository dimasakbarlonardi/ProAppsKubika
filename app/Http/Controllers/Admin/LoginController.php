<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Site;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = Login::all();

        return view('Admin.User.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['sites'] = Site::all();

        return view('Admin.User.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Login::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'id_site' => $request->id_site,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan user');

            return redirect()->route('logins.index');
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
    public function edit(Login $login)
    {
        $data['login'] = $login;
        $data['sites'] = Site::all();

        return view('Admin.User.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Login $login)
    {
        try {
            DB::beginTransaction();

            $login->update($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil mengubah user');

            return redirect()->route('logins.index');

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
    public function destroy(Login $login)
    {
        $login->delete();

        Alert::success('Berhasil', 'Berhasil menghapus user');

        return redirect()->route('logins.index');
    }
}
