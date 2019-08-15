<?php


namespace App\Http\Helpers;


use Illuminate\Http\Request;

class CalendarHelper
{
    public function validateRequest(Request $request)
    {
        echo '<pre>';
        print_r($request);
        exit;
    }
}