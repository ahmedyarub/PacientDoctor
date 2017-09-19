<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/doctors/form', function () { return view('doctors.doctorForm');});
Route::post('/doctors/add', 'DoctorsController@addDoctor');

Route::get('/pacient/form', function () { return view('pacients.pacientForm');});
Route::post('/pacient/add', 'PacientsController@addPacient');