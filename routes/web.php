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

Route::get('/', 'App\Http\Controllers\DefaultController@list')->name('homepage');
Route::any('/review/edit/{id}', 'App\Http\Controllers\DefaultController@edit')->name('edit');
Route::any('/review/create', 'App\Http\Controllers\DefaultController@create')->name('create');
Route::get('/docs', 'App\Http\Controllers\DefaultController@docs')->name('docs');
