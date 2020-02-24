<?php


namespace App\Http\Controllers;


use App\Http\Timer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportData(Request $request)
    {
        $export = new UserExport();
        $export->setDate($request->all());

        return Excel::download(   $export, 'users.xlsx');
    }

}