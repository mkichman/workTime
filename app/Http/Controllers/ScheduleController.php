<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CalendarHelper;
use App\Schedule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $schedule = DB::table('schedules')
                    ->where('userId', '=', $user->id)
                    ->get()
                    ->toArray();

        $timers = DB::table('timers')
                    ->where('userId', '=', $user->id)
                    ->select(['startDate', 'endDate', 'workTime', 'break as description', 'id'])
                    ->get()
                    ->toArray();

//        $timers = $timers->toArray();
        $schedule = array_merge($timers, $schedule);

//        dd($schedule);

//        $schedule = Schedule::all();
        return view('schedule.index', compact('schedule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO validate request if end date is not earlier than start date
        $user = Auth::user();

        $scheduleTable = DB::table('schedules');

        $scheduleTable->insert([
            'userId'        => $user->id,
            'name'          => $request->name,
            'description'   => $request->description,
            'startDate'     => $request->startDate,
            'endDate'       => $request->endDate
        ]);

        return redirect()->route('calendar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$schedule = new Schedule();

        $task = Schedule::where('id', '=', $id)->firstOrFail();

        return view('schedule.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Schedule::findOrfail($id);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->startDate = $request->startDate;
        $task->endDate = $request->endDate;

        $task->save();

        return redirect()->route('calendar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Schedule::findOrfail($id);

        $task->delete();
        return redirect()->route('calendar');
    }

    public function editUnavailable()
    {
        //todo
        die('this is view which says edit is unavailable for this event');
    }
}
