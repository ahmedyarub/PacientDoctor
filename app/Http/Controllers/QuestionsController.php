<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Question;
use App\Http\Models\Category;
use Illuminate\Support\Facades\DB;

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

        return view('home');

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

        return view('home');
    }
}