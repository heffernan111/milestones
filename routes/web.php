<?php

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

Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('files', 'FileController@index')->middleware('auth');
Route::post('/import_parse', 'FileController@parseImport')->name('import_parse')->middleware('auth');;
Route::post('/import_process', 'FileController@processImport')->name('import_process')->middleware('auth');

Auth::routes();