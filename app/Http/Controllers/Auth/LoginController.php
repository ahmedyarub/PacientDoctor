<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Models\Pacient;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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
        $user_id = Auth::user()->id;
        $user_type = Pacient::where('user_id', $user_id)->count() == 1 ? 0 : 1;

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0,
                'user_type' => $user_type]);
        } else {
            if($user_type==0)
                $this->redirectTo = '/categories/selcategory';

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
