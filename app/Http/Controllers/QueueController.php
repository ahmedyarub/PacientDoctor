<?php

namespace App\Http\Controllers;

use App\Http\Models\Cases;
use App\Http\Models\Doctor;
use App\Http\Models\Doubt;
use Illuminate\Http\Request;
use Auth;
use File;

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

    public function submitNotes(Request $request)
    {
        $case = Cases::find($request->case_id);

        $case->notes = $request->notes;

        $case->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            dd('done');
        }
    }

    public function submitCaseResult(Request $request)
    {
        $case = Cases::find($request->case_id);

        $case->case_result = $request->case_result;
        $case->other_notes = $request->other_notes;

        $case->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            dd('done');
        }
    }


    public function getNotes(Request $request)
    {
        $case = Cases::find($request->case_id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'data' => $case->notes]);
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
        else {
            $questions_answers = Doubt::leftJoin('questions', 'questions.id', 'question_id')
                ->leftJoin('answers', 'answers.id', 'answer_id')
                ->where('case_id', $next_case->id)
                ->get(['question', 'answer', 'written_answer'])
                ->reduce(function ($result, $question_answer) {
                    if (!empty($question_answer->answer) || !empty($question_answer->written_answer))
                        $result .= '<br>' . $question_answer->question . '<br>';

                    if (!empty($question_answer->answer))
                        $result .= $question_answer->answer . '<br>';

                    if (!empty($question_answer->written_answer))
                        $result .= $question_answer->written_answer . '<br>';

                    return $result;
                }, '');

            return response()->json(['status' => 0, 'case_id' => $next_case->id,
                'question_answer' => $questions_answers,
                'image' => !empty($next_case->image)
                    ? 'data:image/jpg;base64,' . base64_encode(File::get(storage_path('app/cases/' . $next_case->id . '.jpg')))
                    : '']);
        }
    }

}