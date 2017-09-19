<?php


namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

class DoctorsController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function addDoctor()
    {
        $data = \Request::all();
        print_r($data);
        #return 'teste';
    }
}