<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Pacient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacientsController extends Controller
{

    public function addPacient(Request $request)
    {

        $pacient = $request->validate([
            'name' => 'required',
            'genre'=> 'required',
            'address'=> 'required',
            'email'=> 'required',
            'password'=> 'required',

            'phone'=> 'required',
        ]);

        $pacient->name= $request['name'];
        $pacient->genre= $request['genre'];
        $pacient->address= $request['address'];
        $pacient->birth= $request['birth'];
        $pacient->email = $request['email'];
        $pacient->password= Hash::make($request['password']);
        $pacient->phone= $request['phone'];

        $pacient->save();

        return view('home');

    }

    public function list()
    {
        $pacients = DB::table('pacients')->get();
        return view('pacients.list',['pacients' => $pacients]);
    }
}