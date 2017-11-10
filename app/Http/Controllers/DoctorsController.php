<?php


namespace App\Http\Controllers;

use App\Http\Models\Cases;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use App\Http\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
            'phone' => 'required',
            'address' => 'required',
            'specialization' => 'required',
            'email' => 'required|email',
            'password' => 'required',
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
        $doctor->phone = $request['phone'];
        $doctor->address = $request['address'];
        $doctor->specialization = $request['specialization'];

        $doctor->save();

        $email = new EmailVerification($user);

        $email->from('naoresponder@veus.com.br');
        $email->subject('Activation Email');

        Mail::to($user->email)->send($email);

        DB::commit();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            return redirect()->action('QuestionsController@list');
        }
    }


    public function questionsList()
    {
        $user_id = Auth::id();
        $doctor = DB::table('doctors')->where('user_id', '=', $user_id)->get();
        foreach ($doctor as $doc) {
            $doctor_id = $doc->id;
        }

        $doubts = DB::table('doubts')
            ->select('doubts.doubt_id', 'pacients.name')
            ->leftJoin('pacients', 'doubts.pacient_id', '=', 'pacients.id')
            ->where('doctor_id', '=', $doctor_id)
            ->orderBy('doubts.created_at', 'asc')->get();
        echo '<pre>';
        print_r($doubts);
        foreach ($doubts as $doubt) {

        }
    }


    public function list()
    {
        $doctors = DB::table('doctors')->leftJoin('users', 'users.id', '=', 'doctors.user_id')->get();

        return view('doctors.list', ['doctors' => $doctors]);
    }

    public function delete($id)
    {
        DB::table('doctors')->delete($id);

        return redirect()->action('QuestionsController@list');
    }

    public function nextPatient()
    {
        $doctor_id = Doctor::where('user_id', \Auth::user()->id)->first()->id;

        $last_case = DB::table('cases')->where('doctor_id', $doctor_id)->where('status', 'Pending')->min('id');

        if (empty($last_case))
            return response()->json(['status' => 1, 'error' => 'Last case closed. No more pending cases']);

        DB::table('cases')->where('id', $last_case)->update(['status' => 'Finished']);

        $cur_case = DB::table('cases')->where('doctor_id', $doctor_id)->where('status', 'Pending')->min('id');

        if (empty($last_case))
            return response()->json(['status' => 1, 'error' => 'No more pending cases']);

        return response()->json(['status' => 0, 'doctor_id' => $doctor_id, 'case_id' => $cur_case]);
    }
}