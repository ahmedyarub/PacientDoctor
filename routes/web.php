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
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/doctors/form', 'DoctorsController@form');
Route::post('/doctors/add', 'DoctorsController@addDoctor');
Route::get('/doctors/list', 'DoctorsController@list');
Route::get('/doctors/edit', 'DoctorsController@list');
Route::get('/doctors/delete', 'DoctorsController@list');

Route::get('/pacients/form', 'PacientsController@form');
Route::post('/pacients/add', 'PacientsController@addPacient');
Route::get('/pacients/list', 'PacientsController@list');

Route::get('/register/verify/{token}','Auth\RegisterController@verify');