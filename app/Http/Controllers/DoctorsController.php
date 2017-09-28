<?php


namespace App\Http\Controllers;


use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use App\Http\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;
use Mail;

class DoctorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['form', 'addDoctor']);
    }

    public function form()
    {
        return view('doctors.doctorForm');
    }

    public function addDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'crm' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|email',
            'state' => 'required',
            'city' => 'required',
            'password' => 'required',
            'phone' => 'required',
        ]);

        DB::beginTransaction();

        $user = new User();

        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->email_token = str_random(10);

        $user->save();

        $doctor = new Doctor();

        $doctor->user_id = $user->id;
        $doctor->name = $request['name'];
        $doctor->crm = $request['crm'];
        $doctor->phone = $request['phone'];
        $doctor->address = $request['address'];
        $doctor->state = $request['state'];
        $doctor->city = $request['city'];

        $doctor->save();

        $email = new EmailVerification(new User(['email_token' => $user->email_token, 'name' => $doctor->name]));

        $email->from('naoresponder@veus.com.br');
        $email->subject('Activation Email');

        Mail::to($user->email)->send($email);

        DB::commit();

        return view('home');


    }

    public function list()
    {
        $doctors = DB::table('doctors')->get();

        return view('doctors.list', ['doctors' => $doctors]);
    }
}