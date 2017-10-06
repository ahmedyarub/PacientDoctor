<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Question;
use App\Http\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class QuestionsController extends Controller
{
    public function form(){
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
            ->select('questions.id','questions.question', 'category')->where('category_id', $request['category'])->get();

        $i=0;
        while(count($questions) > $i){
            $answers = DB::table('answers')
            ->leftJoin('questions', 'questions.id', '=', 'answers.question_id')
                ->where('answers.question_id', $questions[$i]->id)->pluck('answers.answer','answers.id');
            $questions[$i]->answers = $answers;
            $i++;
        }

        return view('questions.selectQuestions', ['questions' => $questions, 'category'=> $request['category']]);

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

    public function selectDoctor(Request $request){

        $questions_answers = $request['answers'];

        $category_id = $request['category_id'];

        $doubt_id = DB::table('doubts')->select('doubt_id')->max('doubt_id');

        $doubt_id = ($doubt_id === NULL) ? 0 : $doubt_id+1;


        DB::beginTransaction();
        foreach($questions_answers as $question_id=>$answer_id) {
            DB::table('doubts')->insert(
                ['category_id' => $category_id, 'doubt_id' => $doubt_id, 'pacient_id' => Auth::id(),
                    'question_id'=>$question_id, 'answer_id'=>$answer_id]
            );

        }
        DB::commit();
        $doctors = DB::table('doctors')->pluck('doctors.name', 'doctors.id');

        return view('questions.selectDoctor', ['doctors' => $doctors, 'doubt_id'=>$doubt_id]);
    }
}