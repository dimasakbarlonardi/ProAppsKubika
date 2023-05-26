<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class UserController extends Controller
{
    // public function setConnection()
    // {
    //     $request = Request();
    //     $user_id = $request->user()->id;
    //     $login = Login::where('id', $user_id)->with('site')->first();
    //     $conn = $login->site->db_name;
    //     $user = new User();
    //     $user->setConnection($conn);

    //     return $user;
    // }

    public function index(Request $request)
    {
        $connUser = ConnectionDB::setConnection(new User());

        $data['users'] = $connUser->get();

        return view('AdminSite.User.index', $data);
    }

    public function create()
    {
        $connRole = ConnectionDB::setConnection(new Role());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $connOwner = ConnectionDB::setConnection(new OwnerH());

        $email = [];
        $karyawan = $connKaryawan->where('id_user', null)
            ->get('email_karyawan');

        $tenant = $connTenant->where('id_user', null)
            ->get('email_tenant');

        $owner = $connOwner->where('id_user', null)
            ->get('email_owner');

        foreach ($karyawan as $k) {
            $email[] = $k->email_karyawan;
        }
        foreach ($owner as $o) {
            $email[] = $o->email_owner;
        }
        foreach ($tenant as $t) {
            $email[] = $t->email_tenant;
        }

        $data['email'] = $email;
        $data['roles'] = $connRole->get();

        return view('AdminSite.User.create', $data);
    }

    public function store(Request $request)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connTenant = ConnectionDB::setConnection(new Tenant());
        $lastID = $connUser->latest()->limit(1)->first();

        $login = Login::find($request->user()->id);

        $getKaryawan = $connKaryawan->where('email_karyawan', $request->email)->first();
        $getOwner = $connOwner->where('email_owner', $request->email)->first();
        $getTenant = $connTenant->where('email_tenant', $request->email)->first();

        if (isset($getKaryawan)) {
            $user = $getKaryawan;
            $nama = $getKaryawan->nama_karyawan;
            $email = $getKaryawan->email_karyawan;
        }
        if (isset($getOwner)) {
            $user = $getOwner;
            $nama = $getOwner->nama_pemilik;
            $email = $getOwner->email_owner;
        }
        if (isset($getTenant)) {
            $user = $getTenant;
            $nama = $getTenant->nama_tenant;
            $email = $getTenant->email_tenant;
        }

        try {
            DB::beginTransaction();
            $createUser = $connUser->create([
                'id_site' => $login->id_site,
                'id_user' => strval($lastID->id_user + 1),
                'nama_user' => $nama,
                'login_user' => $email,
                'password_user' => Hash::make($request->password_user),
                'id_status_user' => 1,
                'id_role_hdr' => $request->id_role_hdr,
            ]);

            Login::create([
                'name' => $createUser->nama_user,
                'email' => $createUser->login_user,
                'password' => $createUser->password_user,
                'id_site' => $login->id_site
            ]);

            $user->update([
                'id_user' => $createUser->id_user
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

    public function edit($id)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $connRole = ConnectionDB::setConnection(new Role());

        $data['roles'] = $connRole->get();
        $data['user'] = $connUser->find($id);

        return view('AdminSite.User.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->find($id);
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
