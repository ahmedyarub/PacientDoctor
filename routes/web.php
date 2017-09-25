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
    return view('home');
});

Auth::routes();

Route::get('/doctors/form', function () {
    return view('doctors.doctorForm');
});
Route::post('/doctors/add', 'DoctorsController@addDoctor');
Route::get('/doctors/list', 'DoctorsController@list');
Route::get('/doctors/edit', 'DoctorsController@list');
Route::get('/doctors/delete', 'DoctorsController@list');

Route::get('/pacients/form', function () { return view('pacients.pacientForm');});
Route::post('/pacients/add', 'PacientsController@addPacient');
Route::get('/pacients/list', 'PacientsController@list');

Route::get('/register/verify/{token}','Auth\RegisterController@verify');