<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\User;
use Session;
use Purifier;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id, $sprint_id)
    {
        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $developers = [];

        // fetch project's developers
        foreach($project->users as $user) {
            if ($user->role_id == 3) {
                $developers[] = $user;
            }
        }

        // check if the developer belongs to the project, so he could create new sprints and tasks
        foreach($developers as $developer) {
            if (auth()->user()->id == $developer->id) {
                return view('tasks.create')
                    ->with('developer', $developer)
                    ->with('sprint', $sprint)
                    ->with('project', $project);
            }
        }

        // return to dashboard if this developer or user does not belong to the project
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id, $sprint_id)
    {
        dd($request->request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
