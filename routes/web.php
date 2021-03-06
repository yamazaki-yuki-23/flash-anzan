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

Auth::routes();

Route::view('/', 'top');
Route::get('/play/{level}', 'PlayController@index')->name('play');
Route::post('/result', 'PlayController@result')->name('result');
Route::view('/result', 'top');
Route::get('/result', function () {
    return redirect('/');
});
Route::get('/rank', 'RankController@index')->name('rank');
Route::get('/history', 'HistoryController@index')->name('history');
