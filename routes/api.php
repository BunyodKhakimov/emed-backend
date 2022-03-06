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

Route::get('auth/register', 'AuthController@register')->name('custom.register');
Route::get('auth/verify', 'AuthController@verify')->name('custom.verify');

Route::middleware('api')->post('auth/login', 'AuthController@login')->name('api.login');
Route::middleware(['jwt.auth', 'api'])->post('auth/logout', 'AuthController@logout')->name('api.logout');
Route::middleware(['jwt.auth', 'api'])->post('auth/refresh', 'AuthController@refresh')->name('api.refresh');
Route::middleware(['jwt.auth', 'api'])->post('auth/me', 'AuthController@me')->name('api.me');

Route::middleware(['jwt.auth', 'api'])->get('conversations/index', 'ConversationController@index');
Route::middleware(['jwt.auth', 'api'])->get('conversations/show/{conversation}', 'ConversationController@show');

Route::middleware(['jwt.auth', 'api'])->post('messages/store', 'MessageController@store');
Route::middleware(['jwt.auth', 'api'])->delete('messages/destroy/{message}', 'MessageController@destroy');
