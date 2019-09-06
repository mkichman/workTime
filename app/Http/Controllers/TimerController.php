<?php


namespace App\Http\Controllers;


use App\Http\Timer;
use App\Http\Helpers\TimerHelper;
use Illuminate\Http\Request;


class TimerController extends Controller
{
    public function index()
    {
        $timer = Timer::select('startTime', 'endTime', 'startDate', 'endDate')->get();
        $data = json_decode($timer, TRUE);


        return view('timer')->with('data', $data);
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
       } else {
           false;
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
            //echo 'stop the timer first';
            return false;
            // TODO
        }
       return true;
    }

  public function pause(Request $request)
  {
      $sth = $request->all();

      $timer = Timer::select('break')->where('endDate', NULL)->first();

      foreach($sth as $key => $value)
      {
          if($value > 59)
          {
              die('too long break');
              // todo
          }
          Timer::where('endDate', NULL)->update(['break' => $timer->break + $value]);
      }

  }
}