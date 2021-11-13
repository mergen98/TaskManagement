<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
//        $user->is_admin => 1
//        $user->is_admin => 0
        if ($user->is_admin){
            $tasks = Task::orderByDesc("id")->get();
        }else{
            $tasks = Task::where("user_id", $user->id)->orderByDesc("id")->get();
        }
        return view('home', compact("tasks"));
    }

    public function store(Request $request){
        $user = Auth::user();
        $request->validate([
             "title" => "required|string",
             "content" => "required|string"
        ]);

        Task::create([
            "user_id" => $user->id,
            "title" => $request->get("title"),
            "content" => $request->get("content")
        ]);

        Session::put("success", "Successfully created.");

        return redirect()->back();
    }

    public function update(Request $request, Task $task){
        $task->update([
            "title" => $request->get("title"),
            "content" => $request->get("content")
        ]);
        Session::put("success", "Successfully updated.");
        return redirect()->back();
    }

    public function destroy(Task $task){
        $task->delete();
        Session::put("success", "Successfully deleted.");
        return redirect()->back();
    }
}
