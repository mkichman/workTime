<?php


namespace App\Http\Controllers;


use App\Http\Timer;
use App\Http\Helpers\TimerHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimerController extends Controller
{
    public function index()
    {

        return view('timer');
    }

    public function previousLogs()
    {
        $timer = Timer::select('startTime', 'endTime', 'startDate', 'endDate')->get();

        return view('userProfile')->with($timer);
    }

    public function start(Request $request)
    {
        date_default_timezone_set('Europe/Warsaw');

        $user = Auth::user();

       if($this->isValid($user))
       {
           $timer = new Timer();
           $timer->startTime = date('H:i:s');
           $timer->startDate = date('Y/m/d');
           $timer->userId    = $user->id;
           $timer->workTime  = 0;

           $timer->save();

           return view('timer');
       } else {
           return false;
       }
    }

    public function stop()
    {
        date_default_timezone_set('Europe/Warsaw');
        $user = Auth::user();

        $tableTimers = DB::table('timers');

        $timer = $tableTimers
                ->where('userId', '=', $user->id)
                ->whereNull('endDate')
                ->first();

        if($timer === NULL)
        {
            die('You should start timer first');
            //TODO stopping timer when no timer is started
        }

        $start = Carbon::createFromFormat('H:i:s', $timer->startTime);
        $end = Carbon::createFromFormat('H:i:s', date('H:i:s'));

        $workTime = $start->diff($end);

        $tableTimers
            ->where('userId', '=', $user->id)
            ->update([
            'endTime' => date('H:i:s'),
            'endDate' => date('Y/m/d'),
            'workTime' => $workTime->h . ':' . $workTime->i
        ]);

        return view('timer');
    }

    public function isValid($user)
    {
        $tableTimers = DB::table('timers');

        $timer = $tableTimers
            ->where('userId', '=', $user->id)
            ->whereNull('endDate')
            ->first();

        if($timer !== NULL)
        {
            return false;
        }
       return true;
    }

  public function pause(Request $request)
  {
      $postData = $request->all();

      $timer = Timer::select('break')->where('endDate', NULL)->first();

      foreach($postData as $key => $value)
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