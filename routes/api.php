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

Route::middleware(\App\Http\Middleware\CheckPostMethod::class)->any('/review/create', 'App\Http\Controllers\ApiController@create');
Route::middleware(\App\Http\Middleware\CheckPostMethod::class)->any('/review/update', 'App\Http\Controllers\ApiController@update');
Route::middleware(\App\Http\Middleware\CheckPostMethod::class)->any('/category/create', 'App\Http\Controllers\ApiController@createCategory');
Route::middleware(\App\Http\Middleware\CheckGetMethod::class)->any('/review/get', 'App\Http\Controllers\ApiController@get');
Route::middleware(\App\Http\Middleware\CheckGetMethod::class)->any('/review/getAll', 'App\Http\Controllers\ApiController@getAll');
Route::middleware(\App\Http\Middleware\CheckGetMethod::class)->any('/review/getByPage', 'App\Http\Controllers\ApiController@getByPage');
Route::middleware(\App\Http\Middleware\CheckGetMethod::class)->any('/review/getCount', 'App\Http\Controllers\ApiController@getCount');
