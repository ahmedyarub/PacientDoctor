<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Pacient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacientsController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function addPacient(Request $request)
    {
        $pacient= new Pacient();
        $pacient->name= $request['name'];
        $pacient->genre= $request['genre'];
        $pacient->phone= $request['phone'];
        $pacient->address= $request['address'];
        $pacient->email = $request['email'];
        $pacient->password= Hash::make($request['password']);

        $pacient->save();

        return view('home');

    }

    public function list()
    {
        $pacients = DB::table('pacients')->get();
        return view('pacients.list',['pacients' => $pacients]);
    }
}