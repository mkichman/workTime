<?php


namespace App\Http\Controllers;


use App\Http\Timer;

class TimerController extends Controller
{
    public function index()
    {
        return view('timer');
    }

    public function start()
    {
        $timer = new Timer();
        $timer->startTime = '20:20';
        $timer->endTime = '20:20';
        $timer->startDate = '2019-08-29';
        $timer->endDate = '2019-08-10';

        $timer->save();
    }
}