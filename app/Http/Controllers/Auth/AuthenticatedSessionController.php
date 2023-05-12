<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Login;
use App\Models\Menu;
use App\Models\MenuHeading;
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
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
                'id_site' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                Alert::error('Gagal', 'Mohon periksa kembali email dan password');

                return redirect()->back();
            }

            $user = Login::where('email', $request->email)->with('site')->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $user->update(['id_site' => $request->id_site]);
            $user->save();

            $request->authenticate();

            $request->session()->regenerate();

            $currUser = new User();
            $currUser = $currUser->setConnection($user->site->db_name);
            $getUser = $currUser->where('login_user', $user->email)
                ->with('RoleH.AksesForm')
                ->first();

            $request->session()->put('user', $getUser);
            $request->session()->put('user_id', $getUser->id_user);

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (Exception $error) {
            Alert::error('Gagal', 'Mohon periksa kembali email dan password');

            return redirect()->back();
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
