<?php

namespace App\Http\Controllers;

use App\Http\Helpers\CalendarHelper;
use App\Relation;
use App\Schedule;
use App\Todo;

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

//        $todo = DB::table('todos')
//                    ->where('userId', '=', $user->id)
//                    ->whereNotNull('deadline')
//                    ->select(['name', 'description', 'deadline as startDate', 'deadline as endDate', 'id'])
//                    ->get()
//                    ->toArray();

        $schedule = array_merge($timers, $schedule);

//        $schedule = array_merge($todo, $schedule);

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

        $schedule = new Schedule();

        $schedule->userId       = $user->id;
        $schedule->name         = $request->name;
        $schedule->description  = $request->description;
        $schedule->startDate    = $request->startDate;
        $schedule->endDate      = $request->endDate;
        $schedule->done         = false;

        $schedule->save();

        $todo = new Todo();

        $todo->userId       = $user->id;
        $todo->name         = $request->name;
        $todo->description  = $request->description;
        $todo->deadline    = $request->endDate;
        $todo->done         = false;

        $todo->save();

        $relationTable = DB::table('relations');

        $relationTable->insert([
            'scheduleId'    => $schedule->id,
            'todoId'        => $todo->id,
            'userId'        => $user->id
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
        $user = Auth::user();

        $task = Schedule::findOrfail($id);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->startDate = $request->startDate;
        $task->endDate = $request->endDate;

        $task->save();

        $relation = DB::table('relations')
            ->where('scheduleId', '=', $id)
            ->where('userId', '=', $user->id)
            ->first();

        if(isset($relation))
        {
            $todo = Todo::findOrfail($relation->todoId);
            $todo->name = $request->name;
            $todo->description = $request->description;
            $todo->deadline = $request->endDate;
            $todo->userId = $user->id;

            $todo->save();
        }
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
        $user = Auth::user();

        $task = Schedule::findOrfail($id);

        $task->delete();

        $relation = DB::table('relations')
            ->where('scheduleId', '=', $id)
            ->where('userId', '=', $user->id)
            ->first();

        if(isset($relation))
        {
            $rel = DB::table('relations')
                ->where('relId', '=',  $relation->relId)
                ->delete();

            $todo = Todo::findOrfail($relation->todoId);
            $todo->delete();
        }
        return redirect()->route('calendar');
    }

    public function editUnavailable()
    {
        //todo
        die('this is view which says edit is unavailable for this event');
    }
}
