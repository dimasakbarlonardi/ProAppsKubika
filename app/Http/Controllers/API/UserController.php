<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Login;
use App\Models\OwnerH;
use App\Models\Site;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Config;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    public function setConnection($request)
    {
        $user_id = $request->user()->id;
        $user = Login::find($user_id)->with('site')->first();
        $user = $user->site->db_name;

        return $user;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
            'id_site' => 'required'
        ]);

        try {
            $login = Login::where('email', $request->email)
                ->where('id_site', $request->id_site)
                ->with('site')
                ->first();

            $credentials = [
                'email' => $login->email,
                'password' => $request->password
            ];

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            } else {
                $currUser = new User();
                $currUser = $currUser->setConnection($login->site->db_name);
                $getUser = $currUser->where('login_user', $login->email)
                    ->with(['RoleH.AksesForm', 'RoleH.WorkRelation', 'Karyawan'])
                    ->first();

                if (!Hash::check($request->password, $login->password, [])) {
                    return ResponseFormatter::error([
                        'message' => 'Password anda salah'
                    ], 'Authentication Failed', 500);
                }

                $tokenResult = $login->createToken('authToken')->plainTextToken;

                return ResponseFormatter::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $getUser
                ], 'Authenticated');
            }
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function selectRole(Request $request)
    {
        $role_id = $request->role_id;

        $connUser = ConnectionDB::setConnection(new User);
        $user = $connUser->where('login_user', $request->user()->email)->first();

        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $verified = false;
        if ($role_id == 1) {
            $owner = $connOwner->where('email_owner', $request->user()->email)->first();
            if (isset($owner)) {
                $verified = true;
            }
        }
        if ($role_id == 2) {
            $karyawan = $connKaryawan->where('email_karyawan', $request->user()->email)->first();

            if (isset($karyawan)) {
                $verified = true;
            }
        }
        if ($role_id == 3) {
            $tenant = $connTenant->where('email_tenant', $request->user()->email)->first();
            if (isset($tenant)) {
                $verified = true;
            }
        }
        if ($verified) {
            return ResponseFormatter::success([
                'message' => 'OK'
            ], 'Authenticated');
        } else {
            return ResponseFormatter::error([
                'message' => 'Anda tidak terdaftar'
            ],'Authentication Failed', 500);
        }
    }

    public function user(Request $request)
    {
        $getUser = $request->user();
        $id_site = $getUser->id_site;
        $site = Site::find($id_site);

        $user = new User();
        $user = $user->setConnection($site->db_name);
        $user = $user->where('login_user', $getUser->email)
        ->with('RoleH')
        ->first();
        return ResponseFormatter::success($user, 'Data profile user berhasil diambil');
    }
}
