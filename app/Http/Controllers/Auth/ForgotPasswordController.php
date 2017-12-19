<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $email = $request->email;

        if(empty($user)) {
            return responde()->json(['status' => 1]);
        }else {
            $password = abs(rand(1, 99999999));
            $user->password = \Hash::make($password);
            $user->save();

            \Mail::send('mail.password_reset', ['password' => $password], function ($message) use ($email) {
                $message->from('admin@fam-doc.com')
                    ->to($email)
                    ->subject('Password Reset');
            });

            return response()->json(['status' => 0]);
        }
    }
}
