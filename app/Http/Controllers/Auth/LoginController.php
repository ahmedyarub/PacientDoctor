<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/questions/list';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'getValidateSession');
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            return redirect()->intended($this->redirectPath());
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            return redirect('/');
        }
    }

    public function getValidateSession()
    {
        if (\Auth::check()) {
            return response()->json(['status' => 0]);
        } else {
            return response()->json(['status' => 1]);
        }
    }
}
