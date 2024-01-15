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
use JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Config;
use Symfony\Component\HttpFoundation\Session\Session;

use Appy\FcmHttpV1\FcmNotification;
use Illuminate\Testing\Fluent\Concerns\Has;

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
            'id_site' => 'required',
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
                    ->with(['RoleH.AksesForm', 'RoleH.WorkRelation'])
                    ->first();

                if (!Hash::check($request->password, $login->password, [])) {
                    return ResponseFormatter::error([
                        'message' => 'Password anda salah'
                    ], 'Authentication Failed', 500);
                }

                // $tokenResult = $login->createToken('authToken')->plainTextToken;
                $customClaims = [
                    'id_login' => $login->id,
                    'id_site' => $login->id_site,
                ];
                $token = JWTAuth::claims($customClaims)->attempt($credentials);

                $hasFcm = false;
                if (isset($request->fcm_token)) {
                    $getUser->update([
                        'fcm_token' => $request->fcm_token
                    ]);
                }

                return ResponseFormatter::success([
                    'fcm' => $hasFcm,
                    'access_token' => $token,
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
            ], 'Authentication Failed', 500);
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

    public function logout(Request $request)
    {
        $connUser = ConnectionDB::setConnection(new User);

        $user = $connUser->where('login_user', $request->user()->email)->first();
        $user->fcm_token = null;
        $request->user()->tokens()->delete();
        $user->save();

        return ResponseFormatter::success(null, 'Successfully logout');
    }

    public function resetPassword(Request $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password, [])) {
            return ResponseFormatter::error([
                'message' => 'Wrong password'
            ], 'Authentication Failed', 500);
        }

        if ($request->password != $request->confirm_password) {
            return ResponseFormatter::error([
                'message' => "Password didn't match"
            ], 'Authentication Failed', 500);
        }

        $logins = Login::where('email', Auth::user()->email)->get();
        foreach ($logins as $login) {
            $login->password = Hash::make($request->password);
            $login->save();
        }

        $connUser = ConnectionDB::setConnection(new User());
        $users = $connUser->where('login_user', Auth::user()->email)->get();
        foreach ($users as $user) {
            $user->password_user =  Hash::make($request->password);
            $user->save();
        }

        return ResponseFormatter::success($user, 'Success change password');
    }
}
