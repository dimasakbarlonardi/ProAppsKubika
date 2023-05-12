<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class UserController extends Controller
{
    public function setConnection()
    {
        $request = Request();
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $user = new User();
        $user->setConnection($conn);

        return $user;
    }

    public function index(Request $request)
    {
        $conn = $this->setConnection();

        $data['users'] = $conn->get();

        return view('AdminSite.User.index', $data);
    }

    public function create()
    {
        return view('AdminSite.User.create');
    }

    public function store(Request $request)
    {
        $conn = $this->setConnection();
        $login = Login::find($request->user()->id);

        try {
            DB::beginTransaction();
            $conn->create([
                'id_site' => $login->id_site,
                'id_user' => $request->id_user,
                'nama_user' => $request->nama_user,
                'login_user' => $request->login_user,
                'password_user' => Hash::make($request->password_user),
                'id_status_user' => $request->id_status_user,
                'id_role_hdr' => $request->id_role_hdr,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambah user');

            return redirect()->route('users.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambah user');

            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $conn = $this->setConnection();

        $data['user'] = $conn->find($id);

        return view('AdminSite.User.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $conn = $this->setConnection();
        $user = $conn->find($id);
        $email = $user->login_user;

        try {
            DB::beginTransaction();

            $login = Login::where('email', $email)->first();

            $login->update([
                'email' => $request->login_user,
                'name' => $request->nama_user,
            ]);

            $user->update($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil mengubah user');

            return redirect()->route('users.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal mengubah user');

            return redirect()->back();
        }
    }
}
