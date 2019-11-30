<?php


namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TodoListController extends Controller
{
    public function index()
    {
        $data = Todo::all();

        $data = json_decode($data, TRUE);

        return view('todoList', compact('data'));
    }

    public function create(Request $request)
    {
        $data= $request->all();
        $data['userId'] = Auth::id();
        $data['done'] = 0;

        if(strlen($data['description']) > 120)
        {
            die('too long');
            // todo komunikat za długi opis zadania
        }

        Todo::create($data);
        return redirect()->route('todo');
    }

    public function markAsDone(Request $request)
    {
        $postData = $request->all();

        DB::unprepared("UPDATE todos SET done = CASE WHEN done = true THEN false ELSE true END where id = " . $postData['id']);

        return $this->index();
    }

    public function delete(Request $request)
    {
        $postData = $request->all();

        $task = Todo::findOrfail($postData['id']);

        $task->delete();

        return redirect()->to('todo');
    }
}
