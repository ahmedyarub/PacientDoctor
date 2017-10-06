<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Answer;
use App\Http\Models\Question;
use Illuminate\Support\Facades\DB;

class AnswersController extends Controller
{
    public function form(){
        $question = Question::pluck('question', 'id')->toArray();
        return view('answers.answerForm', ['questions' => $question]);
    }


    public function addAnswer(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        DB::beginTransaction();

        $answer = new Answer();

        $answer->answer = $request['answer'];
        $answer->question_id = $request['question'];


        $answer->save();

        DB::commit();

        return redirect()->action('QuestionsController@list');

    }

    public function list()
    {
        $answers = DB::table('answers')
            ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
            ->select('answers.id', 'answers.answer', 'question')->get();

        return view('answers.list', ['answers' => $answers]);
    }

    public function delete($id)
    {
        DB::table('answers')->delete($id);

        return redirect()->action('QuestionsController@list');
    }
}