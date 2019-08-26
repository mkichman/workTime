<?php


namespace App\Http\Helpers;


use App\Http\Timer;

class TimerHelper
{

    public function stop()
    {
        date_default_timezone_set('Europe/Warsaw');

        $timer = Timer::where('endDate', NULL)->first();

        if($timer === NULL)
        {
            throw new Exception('Nope');
        }

        $timer->endTime = date('H:i:s');
        $timer->endDate = date('Y/m/d');

        $timer->save();

    }
}