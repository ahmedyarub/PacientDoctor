<?php

namespace App\Http\Controllers;

use App\Http\Models\Cases;
use App\Http\Models\Doctor;
use Illuminate\Http\Request;
use Auth;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $doctor_id = Cases::find($request->case_id)->doctor_id;

        $queue_count = Cases::where('status', 'Pending')
            ->where('doctor_id', $doctor_id)
            ->where('id', '!=', $request->case_id)
            ->count();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'queue_count' => $queue_count]);
        } else {

            return view('queue.index')
                ->with('queue_count', $queue_count)
                ->with('case_id', $request->case_id);
        }
    }

    public function submitEvaluation(Request $request)
    {
        $case = Cases::find($request->case_id);

        $case->evaluation = $request->evaluation;

        $case->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            dd('done');
        }
    }

    public function startCall(Request $request)
    {
        $case = Cases::find($request->case_id);

        $case->status = 'Started';

        $case->save();

        return response()->json(['status' => 0]);
    }

    public function nextPatient(Request $request)
    {
        $cur_case = Cases::find($request->case_id);

        if (!empty($cur_case)) {
            $cur_case->status = 'Finished';

            $cur_case->save();
        }

        $next_case = Cases::orderBy('created_at', 'desc')
            ->where(function ($query) {
                $query->where('status', 'Started')
                    ->orWhere('status', 'Pending');
            })
            ->where('doctor_id', Doctor::where('user_id', Auth::user()->id)->first()->id)
            ->first();

        if (empty($next_case))
            return response()->json(['status' => 1]);
        else
            return response()->json(['status' => 0, 'case_id' => $next_case->id]);
    }

}