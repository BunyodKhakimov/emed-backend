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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/register', 'AuthController@refister')->name('custom.register');

Route::get('/verify', 'AuthController@verify')->name('custom.verify');

Route::prefix('auth')->middleware('api')->post('login', 'AuthController@login')->name('api.login');
Route::prefix('auth')->middleware(['jwt.auth', 'api'])->post('logout', 'AuthController@logout')->name('api.logout');
Route::prefix('auth')->middleware(['jwt.auth', 'api'])->post('refresh', 'AuthController@refresh')->name('api.refresh');
Route::prefix('auth')->middleware(['jwt.auth', 'api'])->post('me', 'AuthController@me')->name('api.me');

Route::prefix('conversations')->middleware(['api', 'jwt.auth'])->get('index', 'ConversationController@index');
Route::prefix('conversations')->middleware(['api', 'jwt.auth'])->get('/show/{conversation}', 'ConversationController@show');

Route::prefix('messages')->middleware(['api', 'jwt.auth'])->post('store', 'MessageController@store');
Route::prefix('messages')->middleware(['api', 'jwt.auth'])->delete('/destroy/{message}', 'MessageController@destroy');
