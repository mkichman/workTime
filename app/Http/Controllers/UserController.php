<?php


namespace App\Http\Controllers;


use App\Http\Timer;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{

    public function index()
    {
        $data = Timer::select('startTime', 'endTime', 'startDate', 'endDate')->get();
        $data = json_decode($data, TRUE);

        return view('userProfile', compact('data'));
//        return View::make('userProfile',['data' => $data]);

//        return view('userProfile')->with('data', $data);
    }
}