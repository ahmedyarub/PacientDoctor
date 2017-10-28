<?php

namespace App\Http\Controllers;

use App\Http\Models\Cases;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index($case_id)
    {
        $doctor_id = Cases::find($case_id)->doctor_id;

        return view('queue.index')
            ->with('queue_count', Cases::where('status', 'Pending')
                ->where('doctor_id', $doctor_id)
                ->where('id', '!=',$case_id)
                ->count())
            ->with('case_id', $case_id);
    }

    public function startCall(Request $request){
        $case = Cases::find($request->case_id);

        $case->evaluation = $request->evaluation;
        $case->status = 'Started';

        $case->save();

        dd('done');
    }
}