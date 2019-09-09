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
Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/timer', 'TimerController@index')->middleware('auth');
Route::resource('schedule', 'ScheduleController')->middleware('auth');
Route::get('schedule/create', 'ScheduleController@create')->middleware('auth');
Route::get('schedule', 'ScheduleController@index')->name('calendar')->middleware('auth');
//Route::post('schedule.update', 'ScheduleController@update');

Route::get('schedule/update', 'ScheduleController@create')->middleware('auth');
Route::patch('schedule/update/{schedule}', [
    'as' => 'schedule/update/',
    'uses' => 'ScheduleController@update'
])->middleware('auth');
Route::get('schedule/deleteTask/{id}', [
    'as' => 'deleteTask',
    'uses' => 'ScheduleController@destroy'
])->middleware('auth');
Route::post('timer/start', 'TimerController@start')->name('startTimer')->middleware('auth');
Route::get('timer/start', 'TimerController@index')->middleware('auth');
Route::post('timer/stop', 'TimerController@stop')->name('stopTimer')->middleware('auth');
Route::get('timer/stop', 'TimerController@index')->middleware('auth');
Route::post('timer/pause', 'TimerController@pause')->name('pauseTimer')->middleware('auth');
Route::get('timer/pause', 'TimerController@index')->middleware('auth');
Route::get('timer/logs', 'TimerController@previousLogs')->middleware('auth');



