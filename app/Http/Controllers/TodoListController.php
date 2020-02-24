<?php


namespace App\Http\Controllers;

use App\Relation;
use App\Schedule;
use App\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TodoListController extends Controller
{
    public function index()
    {
        $user  = Auth::user();

        $today = Carbon::now();
        $parsedToday = $today->year . '-' . $today->month . '-' . $today->day;

        $data =  DB::select (DB::raw('Select * from todos where userid =' . $user->id .' and deadline is null or deadline = "' . $parsedToday. '"' ));

        return view('todoList', compact('data'));
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $data['userId'] = Auth::id();
        $data['done'] = 0;

        if(strlen($data['description']) > 120)
        {
            die('Given description is too long');
            // todo komunikat za długi opis zadania
        }

        $todo = Todo::create($data);

        if(isset($data['deadline']))
        {
            $schedule = new Schedule();

            $schedule->startDate    = $data['deadline'];
            $schedule->endDate      = $data['deadline'];
            $schedule->name         = $data['name'];
            $schedule->description  = $data['description'];
            $schedule->userId       = $data['userId'];
            $schedule->done         = false;

            $schedule->save();

            $relation = new Relation();

            $relation->scheduleId   = $schedule->id;
            $relation->todoId       = $todo->id;
            $relation->userId       = $data['userId'];

            $relation->save();
        }
        return redirect()->route('todo');
    }

    public function markAsDone(Request $request)
    {
        $user = Auth::user();
        $postData = $request->all();

        DB::unprepared("UPDATE todos SET done = CASE WHEN done = true THEN false ELSE true END where id = " . $postData['id']);

        $relation = DB::table('relations')
            ->where('scheduleId', '=', $postData['id'])
            ->where('userId', '=', $user->id)
            ->first();

        if(isset($relation))
        {
            DB::unprepared("UPDATE schedules SET done = CASE WHEN done = true THEN false ELSE true END where id = " . $relation->scheduleId);
        }

        return $this->index();
    }

    public function delete(Request $request)
    {
        $postData = $request->all();

        $user = Auth::user();

        $task = Todo::findOrfail($postData['id']);

        $task->delete();

        $relation = DB::table('relations')
            ->where('todoId', '=', $postData['id'])
            ->where('userId', '=', $user->id)
            ->first();

        if(isset($relation))
        {
            $rel = DB::table('relations')
                ->where('relId', '=',  $relation->relId)
                ->delete();

            $task = Schedule::findOrfail($relation->scheduleId);
            $task->delete();
        }
        return redirect()->to('todo');
    }
}
