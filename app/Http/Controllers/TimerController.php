<?php


namespace App\Http\Controllers;


use App\Http\Timer;
use App\Http\Helpers\TimerHelper;


class TimerController extends Controller
{
    public function index()
    {
        return view('timer');
    }

    public function start()
    {
        date_default_timezone_set('Europe/Warsaw');

        $currentDate = date('Y/m/d');

       if($this->isValid($currentDate))
       {
           $timer = new Timer();
           $timer->startTime = date('H:i:s');
           $timer->startDate = date('Y/m/d');

           $timer->save();

           return view('timer');
       }
    }

    public function stop()
    {

        date_default_timezone_set('Europe/Warsaw');

        $timer = Timer::where('endDate', NULL)->first();

        if($timer === NULL)
        {
            echo 'nope';
            die();
            //TODO stopping timer when no timer is started
        }

        $timer->endTime = date('H:i:s');
        $timer->endDate = date('Y/m/d');

        $timer->save();

        return view('timer');
    }

    public function isValid($currentDate)
    {
        $timer = Timer::where('endDate', NULL)->first();


        if($timer !== NULL)
        {
            echo 'stop the timer first';
            return false;
            // TODO
        }
       return true;
    }
}