<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorsController extends Controller
{

    public function addDoctor(Request $request)
    {

        $doctor = $request->validate([
            'name' => 'required',
            'crm'=> 'required|numeric',
            'address'=> 'required',
            'email'=> 'required',
            'state'=> 'required',
            'city'=> 'required',
            'password'=> 'required',
            'phone'=> 'required',
        ]);

        $doctor->name= $request['name'];
        $doctor->crm= $request['crm'];
        $doctor->phone= $request['phone'];
        $doctor->address= $request['address'];
        $doctor->state = $request['state'];
        $doctor->city = $request['city'];
        $doctor->email = $request['email'];
        $doctor->password= Hash::make($request['password']);

        $doctor->save();

        return view('home');



    }

    public function list()
    {
        $doctors = DB::table('doctors')->get();

        return view('doctors.list',['doctors' => $doctors]);
    }
}