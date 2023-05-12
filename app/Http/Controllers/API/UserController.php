<?php

namespace App\Http\Controllers\API;

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
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
                'id_site' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = Login::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function user(Request $request)
    {
        $conn = $this->setConnection($request);
        $unit = new Unit();
        $unit->setConnection($conn);
        $unit = $unit->find(1);

        return $unit;
    }
}
