<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Models\Pacient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DoubtsController extends Controller
{

    public function saveDoubt(Request $request)
    {
        DB::beginTransaction();

        DB::table('doubts')
            ->where('case_id', $request->case_id)
            ->update(['doctor_id' => $request->doctor]);
        DB::table('cases')
            ->where('id', $request->case_id)
            ->update(['doctor_id' => $request->doctor]);
        DB::commit();

        return redirect()->action('QuestionsController@list');

    }


}