<?php

namespace App\Http\Controllers;

use App\Http\Models\Cases;
use Illuminate\Http\Request;

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

    public function startCall(Request $request)
    {
        $case = Cases::find($request->case_id);

        $case->evaluation = $request->evaluation;
        $case->status = 'Started';

        $case->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            dd('done');
        }
    }
}