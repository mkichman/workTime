<?php


namespace App\Http\Controllers;


use App\Http\Timer;

class UserController extends Controller
{

    public function index()
    {
        $data = Timer::select('startTime', 'endTime', 'startDate', 'endDate')->get();
        $data = json_decode($data, TRUE);

        return view('userProfile', compact('data'));
    }
}