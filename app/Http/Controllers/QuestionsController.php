<?php


namespace App\Http\Controllers;

use App\Http\Models\Cases;
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
        $question->choices = empty($request['choices']) ? false : true;
        $question->text = empty($request['text']) ? false : true;

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
            ->select('questions.id', 'questions.question', 'category', 'choices', 'text')->where('category_id', $request['category'])->get();

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
        $pacient = DB::table('pacients')->where('user_id', '=', $user_id)->get();
        foreach ($pacient as $pac) {
            $pacient_id = $pac->id;
        }

        DB::beginTransaction();

        $case = new Cases();

        $case->pacient_id = $pacient_id;
        $case->status = 'Pending';

        $case->save();

        if (!empty($request->file())) {
            $case->image = $case->id . '.' . $request->file('image')->getClientOriginalExtension();

            $request->file('image')->storeAs('cases', $case->image);

            $case->save();
        }

        foreach ($questions_answers as $question_id => $answer_id) {
            DB::table('doubts')->insert(
                ['category_id' => $category_id, 'case_id' => $case->id, 'pacient_id' => $pacient_id,
                    'question_id' => $question_id, 'answer_id' => $answer_id, 'written_answer' => $questions_written_answers[$question_id]]
            );
        }

        DB::commit();

        $doctors = DB::table('doctors')->get(['doctors.name', 'doctors.id']);

        $doctors_evaluations = $doctors->map(function ($doctor) {
            $evaluation_count = Cases::where('doctor_id', $doctor->id)->where('status', 'Finished')->count('id');

            $evaluation = Cases::where('doctor_id', $doctor->id)->where('status', 'Finished')->sum('evaluation') /
                ($evaluation_count == 0 ? 1 : $evaluation_count);

            return ['id' => $doctor->id, 'name' => ($doctor->name . '(stars: ' . $evaluation . ', cases: ' . $evaluation_count . ')')];
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'data' => ['doctors' => $doctors_evaluations, 'case_id' => $case->id]]);
        } else {
            return view('questions.selectDoctor', ['doctors' => $doctors_evaluations->pluck('name', 'id'), 'case_id' => $case->id]);
        }
    }
}