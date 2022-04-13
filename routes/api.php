<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('auth/register', 'AuthController@register')->name('custom.register');
Route::post('auth/verify', 'AuthController@verify')->name('custom.verify');

Route::middleware('api')->post('auth/login', 'AuthController@login')->name('api.login');
Route::middleware(['jwt.auth', 'api'])->post('auth/logout', 'AuthController@logout')->name('api.logout');
Route::middleware(['jwt.auth', 'api'])->post('auth/refresh', 'AuthController@refresh')->name('api.refresh');
Route::middleware(['jwt.auth', 'api'])->post('auth/me', 'AuthController@me')->name('api.me');

Route::middleware(['jwt.auth', 'api'])->get('conversations/index', 'ConversationController@index');
Route::middleware(['jwt.auth', 'api'])->get('conversations/show/{conversation}', 'ConversationController@show');

Route::middleware(['jwt.auth', 'api'])->post('messages/store', 'MessageController@store');
Route::middleware(['jwt.auth', 'api'])->delete('messages/destroy/{message}', 'MessageController@destroy');

Route::middleware(['jwt.auth', 'api'])->get('doctors/index', 'DoctorController@index');
Route::middleware(['jwt.auth', 'api'])->get('doctors/show/{doctor}', 'DoctorController@show');
Route::middleware(['jwt.auth', 'api'])->post('doctors/store', 'DoctorController@store');
Route::middleware(['jwt.auth', 'api'])->put('doctors/update/{doctor}', 'DoctorController@update');
Route::middleware(['jwt.auth', 'api'])->delete('doctors/destroy/{doctor}', 'DoctorController@destroy');

Route::middleware(['jwt.auth', 'api'])->get('patients/show/{patient}', 'PatientController@show');
Route::middleware(['jwt.auth', 'api'])->post('patients/store', 'PatientController@store');
Route::middleware(['jwt.auth', 'api'])->put('patients/update/{patient}', 'PatientController@update');
Route::middleware(['jwt.auth', 'api'])->delete('patients/destroy/{patient}', 'PatientController@destroy');

Route::middleware(['jwt.auth', 'api'])->get('prescriptions/index', 'PrescriptionController@index');
Route::middleware(['jwt.auth', 'api'])->get('prescriptions/show/{prescription}', 'PrescriptionController@show');
Route::middleware(['jwt.auth', 'api'])->post('prescriptions/store', 'PrescriptionController@store');
Route::middleware(['jwt.auth', 'api'])->put('prescriptions/update/{prescription}', 'PrescriptionController@update');
Route::middleware(['jwt.auth', 'api'])->delete('prescriptions/destroy/{prescription}', 'PrescriptionController@destroy');
