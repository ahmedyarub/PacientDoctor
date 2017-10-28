<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Question;
use App\Http\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class QuestionsController extends Controller
{
    public function form()
    {
        $categories = Category::pluck('category', 'id')->toArray();
        return view('questions.questionsForm', ['categories' => $categories]);
    }


    public function addQuestion(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'question' => 'required'
        ]);

        DB::beginTransaction();

        $question = new Question();

        $question->question = $request['question'];
        $question->category_id = $request['category'];


        $question->save();

        DB::commit();

        return redirect()->action('QuestionsController@list');

    }

    public function selectQuestions(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ]);


        $questions = DB::table('questions')
            ->leftJoin('categories', 'categories.id', '=', 'questions.category_id')
            ->select('questions.id', 'questions.question', 'category')->where('category_id', $request['category'])->get();

        $i = 0;
        while (count($questions) > $i) {
            $answers = DB::table('answers')
                ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
                ->where('answers.question_id', $questions[$i]->id)->pluck('answers.answer', 'answers.id');
            $questions[$i]->answers = $answers;
            $i++;
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'data' => $questions]);
        } else {
            return view('questions.selectQuestions', ['questions' => $questions, 'category' => $request['category']]);
        }
    }

    public function list()
    {
        $questions = DB::table('questions')
            ->leftJoin('categories', 'categories.id', '=', 'questions.category_id')
            ->select('questions.id', 'questions.question', 'category')->get();

        return view('questions.list', ['questions' => $questions]);
    }

    public function delete($id)
    {
        DB::table('questions')->delete($id);

        return redirect()->action('QuestionsController@list');
    }

    public function selectDoctor(Request $request)
    {

        $questions_answers = $request['answers'];
        $questions_written_answers = $request['written_answers'];

        $category_id = $request['category_id'];

        $user_id = Auth::id();
        $pacient = DB::table('pacients')->where('user_id','=',$user_id)->get();
        foreach($pacient as $pac){
            $pacient_id = $pac->id;
        }

        DB::beginTransaction();

        $case_id = DB::table('cases')->insertGetId(['pacient_id' => $pacient_id, 'status' => 'Pending']);

        foreach ($questions_answers as $question_id => $answer_id) {
            DB::table('doubts')->insert(
                ['category_id' => $category_id, 'case_id' => $case_id, 'pacient_id' => $pacient_id,
                    'question_id' => $question_id, 'answer_id' => $answer_id, 'written_answer' => $questions_written_answers[$question_id]]
            );
        }

        DB::commit();

        $doctors = DB::table('doctors')->pluck('doctors.name', 'doctors.id');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'data' => ['doctors' => $doctors, 'case_id' => $case_id]]);
        } else {
            return view('questions.selectDoctor', ['doctors' => $doctors, 'case_id' => $case_id]);
        }
    }
}