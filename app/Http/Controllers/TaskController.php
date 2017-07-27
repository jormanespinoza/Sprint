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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $sprint_id, $task_id)
    {
        $task = Task::find($task_id);
        $sprint = Sprint::find($sprint_id);
        $project = Project::find($project_id);

        $leaders = [];
        $developers = [];

        $there_are_leaders = false;
        $there_are_developers = false;

        // fetch project's developers and leaders
        foreach($project->users as $user) {
            if ($user->role_id == 2) {
                $leaders[] = $user;
                $there_are_leaders = true;
            }
            if ($user->role_id == 3) {
                $developers[] = $user;
                $there_are_developers = true;
            }
        }

        // check user role
        if ($there_are_leaders) {
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('tasks.edit')
                        ->with('task', $task)
                        ->with('sprint', $sprint)
                        ->with('user', $leader)
                        ->with('project', $project);
                }
            }
        }

        if ($there_are_developers) {
            foreach($developers as $developer) {
                if (auth()->user()->id == $developer->id) {
                    return view('tasks.edit')
                        ->with('task', $task)
                        ->with('sprint', $sprint)
                        ->with('user', $developer)
                        ->with('project', $project);
                }
            }
        }

        // return to dashboard if this developer or user does not belong to the project
        return redirect('/dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $project_id, $sprint_id, $task_id)
    {
        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $task = Task::find($task_id);

        if ($request->input('changing_status')) {
            $task->status_id = $request->input('status_id');
        }else {
            if ($task->status_id == 1 || auth()->user()->role_id == 2) {
                $this->validate($request, [
                    'name'          => 'required|min:2|max:255',
                    'description'   => 'required|min:4',
                    'hours'         => 'integer|min:1|max:12'
                ]);

                $task->name = $request->input('name');
                $task->hours = $request->input('hours');
                $task->description = Purifier::clean($request->input('description'));
            }else {
                $this->validate($request, [
                    'description'   => 'required|min:4',
                ]);

                $task->description = Purifier::clean($request->input('description'));
            }
        }

        // save task data
        $task->save();

        Session::flash('success', 'La tarea del sprint fue actualizada sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $sprint_id, $task_id)
    {
        $task = Task::find($task_id);
        $sprint = Sprint::find($sprint_id);

        $task->delete();

        $project = Project::find($project_id);

        Session::flash('success', 'La tarea fue eliminada sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }
}
