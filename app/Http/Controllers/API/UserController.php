<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Site;
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

            $this->setMidtrans($request);

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

    public function user(Request $request)
    {
        $getUser = $request->user();
        $id_site = $getUser->id_site;
        $site = Site::find($id_site);

        $user = new User();
        $user = $user->setConnection($site->db_name);
        $user = $user->where('login_user', $getUser->email)->first();

        return ResponseFormatter::success($user, 'Data profile user berhasil diambil');
    }

    public function setMidtrans($request)
    {
        $path = base_path('.env');
        $site = Site::find($request->id_site);

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'MIDTRANS_MERCHAT_ID=' . env('MIDTRANS_MERCHAT_ID'),
                'MIDTRANS_MERCHAT_ID=' . $site->midtrans_merchant_id,
                file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'MIDTRANS_CLIENT_KEY=' . env('MIDTRANS_CLIENT_KEY'),
                'MIDTRANS_CLIENT_KEY=' . $site->midtrans_client_key,
                file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'MIDTRANS_SERVER_KEY=' . env('MIDTRANS_SERVER_KEY'),
                'MIDTRANS_SERVER_KEY=' . $site->midtrans_server_key,
                file_get_contents($path)
            ));
        }
    }
}
