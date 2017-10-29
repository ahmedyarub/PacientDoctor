<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            return redirect()->action('QueueController@index', ['case_id' => $request->case_id]);
        }
    }


}