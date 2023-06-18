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

Route::post('/review/create', 'App\Http\Controllers\ApiController@create');
Route::post('/review/update', 'App\Http\Controllers\ApiController@update');
Route::post('/category/create', 'App\Http\Controllers\ApiController@createCategory');
Route::get('/review/get', 'App\Http\Controllers\ApiController@get');
Route::get('/review/getAll', 'App\Http\Controllers\ApiController@getAll');
Route::get('/review/getCount', 'App\Http\Controllers\ApiController@getCount');
