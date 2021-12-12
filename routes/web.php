<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('check_auth', 'HomeController@checkAuth');
    Route::post('patients', 'PatientController@getPatients');
    Route::post('manage_patients/{patient?}', 'PatientController@managePatients');

    Route::post('selected_patient', 'PatientController@getSelectedPatient');

    Route::post('manage_treatment/{treatment?}', 'PatientController@manageTreatment');

    Route::get('vaccines', 'VaccineController@getVaccines');
    Route::post('manage_vaccines/{vaccine?}', 'VaccineController@manageVaccines');

    Route::get('personnels', 'PersonnelController@getPersonnels');
    Route::post('manage_personnel/{personnel?}', 'PersonnelController@managePersonnel');

    Route::get('roles', 'RoleController@getRoles');
    Route::post('manage_role/{role?}', 'RoleController@manageRole');

    Route::get('users', 'UserController@getUsers');
    Route::post('manage_user/{user?}', 'UserController@manageUser');

    //Route::get('/home', 'HomeController@index')->name('home');

    //Route::get('/home/sample', 'HomeController@index')->name('home');
    Route::get('/{any}', 'HomeController@index')->name('basePage')->where('any',  '.*');
});
//Route::get('/home/sample', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->where('any',  '.*');
