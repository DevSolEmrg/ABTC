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

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('check_auth', 'HomeController@checkAuth');
    Route::post('manage_patients/{patient?}', 'PatientController@managePatients');
    
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/home/sample', 'HomeController@index')->name('home');
    Route::get('/{any}', 'HomeController@index')->name('home')->where('any',  '.*');
});
//Route::get('/home/sample', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->where('any',  '.*');
