<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('pessoas', 'App\Http\Controllers\ApiController@getPessoas');
Route::get('pessoas/{id}', 'App\Http\Controllers\ApiController@getPessoa');
Route::post('pessoas', 'App\Http\Controllers\ApiController@createPessoa');
Route::put('pessoas/{id}', 'App\Http\Controllers\ApiController@updatePessoa');
Route::delete('pessoas/{id}','App\Http\Controllers\ApiController@deletePessoa');

