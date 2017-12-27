<?php


namespace App\Http\Controllers;

use App\Http\Models\Doctor;
use App\Http\Models\Pacient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        if (Auth::user()->isDoctor()) {
            $profile = User::leftJoin('doctors', 'user_id', 'users.id')
                ->where('users.id', Auth::id())
                ->first(['email', 'name', 'phone', 'address', 'specialization']);
        } else {
            $profile = User::leftJoin('pacients', 'user_id', 'users.id')
                ->where('users.id', Auth::id())
                ->first(['email', 'name', 'phone', 'genre', 'city', 'state']);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0, 'data' => $profile]);
        } else {
            return view('auth.profile')
                ->with('profile', $profile);
        }
    }

    public function update_profile(Request $request)
    {
        if (Auth::user()->isDoctor()) {
            $doctor = Doctor::where('user_id', Auth::id())->first();

            $doctor->name = $request->name;
            $doctor->address = $request->address;
            $doctor->phone = $request->phone;
            $doctor->specialization = $request->specialization;

            $doctor->save();
        } else {
            $patient = Pacient::where('user_id', Auth::id())->first();

            $patient->name = $request->name;
            $patient->genre = $request->genre;
            $patient->phone = $request->phone;
            $patient->city = $request->city;
            $patient->state = $request->state;

            $patient->save();
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 0]);
        } else {
            return redirect()->back();
        }
    }
}