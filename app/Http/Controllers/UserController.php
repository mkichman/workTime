<?php


namespace App\Http\Controllers;


use App\Http\Timer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $tableTimers = DB::table('timers');
        $user = Auth::user();

        $data = $tableTimers
            ->where('userId', '=', $user->id)
            ->select(['startTime', 'endTime', 'startDate', 'break', 'workTime'])
            ->get();

        $data = json_decode($data, TRUE);

        return view('userProfile', compact('data'));
    }
}