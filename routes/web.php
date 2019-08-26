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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');
Route::get('/timer', 'TimerController@index');
Route::resource('schedule', 'ScheduleController');
Route::get('schedule/create', 'ScheduleController@create');
Route::get('schedule', 'ScheduleController@index')->name('calendar');
//Route::post('schedule.update', 'ScheduleController@update');

Route::get('schedule/update', 'ScheduleController@create');
Route::patch('schedule/update/{schedule}', [
    'as' => 'schedule/update/',
    'uses' => 'ScheduleController@update'
]);
Route::get('schedule/deleteTask/{id}', [
    'as' => 'deleteTask',
    'uses' => 'ScheduleController@destroy'
]);
Route::get('/start', 'TimerController@start')->name('startTimer');
Route::get('/stop', 'TimerController@stop')->name('stopTimer');



