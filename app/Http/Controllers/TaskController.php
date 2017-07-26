<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\User;
use App\Models\Status;
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
        $leaders = [];

        $user_as_developer = false;
        $user_as_leader = false;

        // fetch project's users
        foreach($project->users as $user) {
            if ($user->role_id == 3) {
                $developers[] = $user;
                $user_as_developer = true;
            }
            if ($user->role_id == 2) {
                $leaders[] = $user;
                $user_as_leader = true;
            }
        }


        if ($user_as_developer) {
            // check if the developer belongs to the project, so he could create new sprints and tasks
            foreach($developers as $developer) {
                if (auth()->user()->id == $developer->id) {
                    return view('tasks.create')
                        ->with('user', $developer)
                        ->with('sprint', $sprint)
                        ->with('project', $project);
                }
            }
        }

        if ($user_as_leader) {
            // check if the developer belongs to the project, so he could create new sprints and tasks
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('tasks.create')
                        ->with('user', $leader)
                        ->with('sprint', $sprint)
                        ->with('project', $project);
                }
            }
        }

        // return to dashboard if this developer or user does not belong to the project
        return redirect('/dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id, $sprint_id)
    {
        $this->validate($request, [
            'name'          => 'required|min:2|max:255',
            'description'   => 'required|min:4',
            'hours'         => 'integer|min:1|max:12'
        ]);

        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $task = new Task;

        // save task data
        $task->name = $request->name;
        $task->description = Purifier::clean($request->description);
        $task->hours = $request->hours;
        $task->sprint_id = $sprint->id;

        $task->save();

        Session::flash('success', 'La tarea del sprint fue creada sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
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
