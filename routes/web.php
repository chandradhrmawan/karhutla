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


Route::get('/admin','AdminController@index');

Route::get('/register','AuthController@getRegister')->name('register')->middleware('guest');
Route::post('/register','AuthController@postRegister')->middleware('guest');
Route::get('/login','AuthController@getLogin')->name('login')->middleware('guest');
Route::post('/login','AuthController@postLogin')->middleware('guest');

Route::get('/home','AuthController@dashboard')->name('home')->middleware('auth');

Route::get('/logout','AuthController@logout')->name('logout')->middleware('auth');

Route::get('/report','ReportController@index')->name('report')->middleware('auth');

Route::get('/get_report_conf','ReportController@get_report_conf');



Route::get('/get_kabupaten/{id_prov}','ReportController@get_kabupaten');
Route::get('/get_kecamatan/{id_kab}','ReportController@get_kecamatan');
Route::get('/get_kelurahan/{id_kec}','ReportController@get_kelurahan');
Route::get('/get_master_data/{id}','MasterController@get_master_data');
Route::get('/update_master_data/{id}/{nilai}','MasterController@update_master_data');

Route::get('/get_master_data_user/{id}','MasterController@get_master_data_user');
Route::get('/update_master_data_user/{id}/{status}','MasterController@update_master_data_user');
Route::get('/sumbit_batal/{id_pelaporan}/{alasan_batal}','MasterController@sumbit_batal');

Route::get('/get_form','ReportController@get_form');
Route::get('/get_report_data','ReportController@get_report_data');

Route::get('/hist_pelaporan/{id_user?}','ReportController@hist_pelaporan')->name('riwayat_lapor');

Route::get('/master_data','MasterController@index')->name('master_data');
Route::get('/master_user','MasterController@master_user')->name('master_user');

Route::get('/test','ReportController@test');

Route::post('/get_distance','ReportController@getDistanceBetween');


Route::post('/read_image','ReportController@read_image');
Route::post('/submit_form','ReportController@submit_form');

// Route::get('/login','LoginController@index');
