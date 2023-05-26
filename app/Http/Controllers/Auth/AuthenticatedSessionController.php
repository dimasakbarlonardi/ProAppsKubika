<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Karyawan;
use App\Models\Login;
use App\Models\Menu;
use App\Models\MenuHeading;
use App\Models\OwnerH;
use App\Models\Tenant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    public function getMenu($id)
    {
        $menu = Menu::find($id);

        return $menu;
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
            'id_site' => 'required'
        ]);

        try {
            $user = Login::where('email', $request->email)->with('site')->first();

            $currUser = new User();
            $currUser = $currUser->setConnection($user->site->db_name);
            $getUser = $currUser->where('login_user', $user->email)
                ->with('RoleH.AksesForm')
                ->first();

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                Alert::error('Gagal', 'Mohon periksa kembali email dan password');

                return redirect()->back();
            } else {
                if (Auth::check()) {
                    if (!Hash::check($request->password, $user->password, [])) {
                        throw new \Exception('Invalid Credentials');
                    }

                    if (isset($getUser)) {
                        $request->authenticate();
                        $request->session()->regenerate();

                        $request->session()->put('user', $getUser);
                        $request->session()->put('user_id', $getUser->id_user);

                        return redirect()->route('select-role');
                    } else {
                        Auth::guard('web')->logout();

                        $request->session()->invalidate();

                        $request->session()->regenerateToken();

                        Alert::error('Gagal', 'Anda tidak terdaftar');

                        return redirect()->route('login');
                    }
                }
            }
        } catch (Exception $error) {
            Alert::error('Gagal', 'Mohon periksa kembali email dan password');

            return redirect()->back();
        }
    }

    public function selectRole()
    {
        return view('auth.select-role');
    }

    public function storeRole(Request $request)
    {
        $user = $request->session()->get('user');

        $connKaryawan = ConnectionDB::setConnection(new Karyawan());
        $connOwner = ConnectionDB::setConnection(new OwnerH());
        $connTenant = ConnectionDB::setConnection(new Tenant());

        $verified = false;
        if ($request->role_id == 1) {
            $owner = $connOwner->where('email_owner', $user->login_user)->first();
            // dd($user, $owner);
            if (isset($owner)) {
                $verified = true;
            }
        }
        if ($request->role_id == 2) {
            $karyawan = $connKaryawan->where('email_karyawan', $user->login_user)->first();

            if (isset($karyawan)) {
                $verified = true;
            }
        }
        if ($request->role_id == 3) {
            $tenant = $connTenant->where('email_tenant', $user->login_user)->first();
            if (isset($tenant)) {
                $verified = true;
            }
        }

        if ($verified) {
            $request->session()->put('has_role', 'yes');

            return redirect()->route('dashboard');
        }

        Alert::error('Gagal', 'Anda tidak terdaftar');

        return redirect()->back();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // $user = $request->session()->get('user');
        // $user->id_role_hdr = '';
        // $user->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
