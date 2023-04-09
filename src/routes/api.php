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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'App\Http\Controllers\AuthController@login');

//GET - users
Route::middleware('jwt.auth')->get('/users', 'App\Http\Controllers\UserController@index');
Route::middleware('jwt.auth')->get('/users/{id}', 'App\Http\Controllers\UserController@show');
Route::get('users/search', 'App\Http\Controllers\UserController@search');


//POST|PUT - users
Route::post('users', 'App\Http\Controllers\UserController@store');
Route::put('users/{id}', 'App\Http\Controllers\UserController@update');

//DESTROY - users
Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy');