<?php


namespace App\Http\Controllers;

use App\Http\Models\CaseMessage;
use App\Http\Models\Cases;
use App\Http\Models\Pacient;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use App\Http\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Mail;
use Carbon;

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

        $email->from('admin@fam-doc.com');
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

    public function doctor_cases(Request $request)
    {
        $doctor_id = Doctor::where('user_id', \Auth::user()->id)->first()->id;

        $cases = Cases::where('doctor_id', $doctor_id)
            ->leftJoin('pacients', 'pacient_id', 'pacients.id')
            ->get(['cases.id', 'pacients.name', 'cases.created_at'])
            ->mapWithKeys(function ($case) {
                return [$case->id => ($case->id . ' ' . $case->name . ' (' . (new Carbon\Carbon($case->created_at))->toDateString() . ')')];
            });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'cases' => $cases]);
        } else {
            return view('doctors.cases')
                ->with('cases', $cases);
        }
    }

    public function send_message(Request $request)
    {
        $request->validate([
            'case_id' => 'required',
            'message' => 'required'
        ]);

        $case_message = new CaseMessage();

        $case_message->case_id = $request->case_id;
        $case_message->message = $request->message;

        $case_message->save();

        $pacient_user = User::find(Pacient::find(Cases::find($request->case_id)->pacient_id)->user_id);
        $push_id = $pacient_user->push_id;
        if (!empty($push_id)) {
            define('API_ACCESS_KEY', 'AAAADsbx6lM:APA91bEny6U-jtdm4R97DzK12aTZDjXIv_PGEcPyGu1OvdGTLTsu2mMSevAA0LdtY0lCJbKy-mb3sm4cA7uMWD0QooAiMIVOpyjmDO0ZcgmR54saLmiVstulCWHBiddEou4s0xlzp2hO');

            $msg = array
            (
                'body' => $request->message,
                'title' => 'Fam-doc Message',
                'icon' => 'myicon',/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
            );

            switch ($pacient_user->platform) {
                case 'iOS':
                    $fields = [
                        'to' => $push_id,
                        'notification' => $msg
                    ];
                    break;
                default:
                    $fields = [
                        'to' => push_id,
                        'data' => $msg
                    ];
            }

            $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_exec($ch);
            curl_close($ch);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            return redirect()->back();
        }

    }
}