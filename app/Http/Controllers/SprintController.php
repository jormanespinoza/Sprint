<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Status;
use App\Models\Task;
use Session;
use Purifier;
use Carbon\Carbon;

class SprintController extends Controller
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
    public function create($project_id)
    {
        $project = Project::find($project_id);
        $leaders = [];

        // fetch project's developers
        foreach($project->users as $user) {
            if ($user->role_id == 2) {
                $leaders[] = $user;
            }
        }

        // check if the leader belongs to the project, so he is able create new sprints
        foreach($leaders as $leader) {
            if (auth()->user()->id == $leader->id) {
                return view('sprints.create')
                    ->with('leader', $leader)
                    ->with('project', $project);
            }
        }

        // return to dashboard if this leader or user does not belong to the project
        return redirect()->route('project.show', [$project_>id, $sprint->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id)
    {
        if ($request->starts_on != null || $request->ends_on != null ) {
            $this->validate($request, [
                'name'              => 'required|min:2|max:255',
                'description'       => 'required|min:4',
                'starts_on'         => 'date|before_or_equal:ends_on',
                'ends_on'           => 'date|after_or_equal:starts_on',
                'hours'             => 'integer|min:1|max:40'
            ]);

            $sprint->starts_on = $request->starts_on;
            $sprint->ends_on = $request->ends_on;
        }else {
            $this->validate($request, [
                'name'              => 'required|min:2|max:255',
                'description'       => 'required|min:4',
                'hours'             => 'integer|min:1|max:40'
            ]);
        }

        $project = Project::find($project_id);

        $sprint = new Sprint;
        $sprint->name = $request->name;
        $sprint->description = Purifier::clean($request->description);
        $sprint->project_id = $project->id;
        $sprint->hours = $request->hours;

        $sprint->save();

        Session::flash('success', 'Sprint generado sin problemas.');
        return redirect()->route('project.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function show($project_id, $sprint_id)
    {

        $sprint = Sprint::find($sprint_id);
        $project = Project::find($project_id);
        $editor = User::find($sprint->edited_by);
        $tasks = $sprint->tasks;
        $statuses = Status::orderBy('id', 'desc')->get();
        $all_tasks_confirmed = false;
        $hours = [1,2,3,5,8,13];
        $task_hours = [];

        $task_total_hours = 0;

        if (count($tasks) > 0) {
            $all_tasks_confirmed = true;
            foreach($tasks as $task) {
                $task_total_hours += $task->hours;
                // check tasks confirmation to show Sprint in green color
                if ($task->status_id != 5) {
                    $all_tasks_confirmed = false;
                }
            }
        }

        foreach($hours as $hour) {
            if ($hour <= $sprint->hours - $task_total_hours) {
                if ($hour == 1) {
                    $task_hours[$hour] = $hour + ' hora';
                }else{
                    $task_hours[$hour] = $hour + ' horas';
                }
            }
        }

        // updates the Sprint's Status wheter it's done or not
        if($all_tasks_confirmed) {
            $sprint->done = true;
            $sprint->save();
        }else if ($sprint->done) {
            $sprint->done = false;
            $sprint->save();
        }

        // fecth all sprint tasks for pagination
        $tasks = Task::where('sprint_id', $sprint_id)->orderBy('status_id', 'desc')->orderBy('updated_at', 'asc')->paginate(15);

        $leaders = [];
        $developers = [];
        $clients = [];

        $there_are_leaders = false;
        $there_are_developers = false;
        $there_are_clients = false;

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
            if ($user->role_id == 4) {
                $clients[] = $user;
                $there_are_clients = true;
            }
        }

        // fetch statuses' descriptions
        $statuses_description = [];

        foreach($statuses as $status) {
            $statuses_description[$status->id] = $status->description;
        }

        // check user role
        if ($there_are_leaders) {
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('sprints.show')
                        ->with('sprint', $sprint)
                        ->with('user', $leader)
                        ->with('project', $project)
                        ->with('statuses', $statuses_description)
                        ->with('tasks', $tasks)
                        ->with('task_total_hours', $task_total_hours)
                        ->with('sprint_done', $all_tasks_confirmed)
                        ->with('task_hours', $task_hours)
                        ->with('editor', $editor);
                }
            }
        }

        if ($there_are_developers) {
            foreach($developers as $developer) {
                if (auth()->user()->id == $developer->id) {
                    return view('sprints.show')
                        ->with('sprint', $sprint)
                        ->with('user', $developer)
                        ->with('project', $project)
                        ->with('tasks', $tasks)
                        ->with('statuses', $statuses_description)
                        ->with('task_total_hours', $task_total_hours)
                        ->with('sprint_done', $all_tasks_confirmed)
                        ->with('task_hours', $task_hours)
                        ->with('editor', $editor);
                }
            }
        }

        if ($there_are_clients) {
            foreach($clients as $client) {
                if (auth()->user()->id == $client->id) {
                    return view('sprints.show')
                        ->with('sprint', $sprint)
                        ->with('user', $client)
                        ->with('project', $project)
                        ->with('tasks', $tasks)
                        ->with('statuses', $statuses_description)
                        ->with('task_total_hours', $task_total_hours)
                        ->with('sprint_done', $all_tasks_confirmed)
                        ->with('task_hours', $task_hours)
                        ->with('editor', $editor);
                }
            }
        }

        // return to dashboard if this developer or user does not belong to the project
        return redirect()->route('project.show', [$project_>id, $sprint->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $sprint_id)
    {
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
            /*
            if ($user->role_id == 3) {
                $developers[] = $user;
                $there_are_developers = true;
            }
            */
        }

        // check user role
        if ($there_are_leaders) {
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('sprints.edit')
                        ->with('sprint', $sprint)
                        ->with('user', $leader)
                        ->with('project', $project);
                }
            }
        }

        /*
        if ($there_are_developers) {
            foreach($developers as $developer) {
                if (auth()->user()->id == $developer->id) {
                    return view('sprints.edit')
                        ->with('sprint', $sprint)
                        ->with('user', $developer)
                        ->with('project', $project);
                }
            }
        }
        */

        // return to dashboard if this developer or user does not belong to the project
        return redirect()->route('project.show', [$project_>id, $sprint->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, $sprint_id)
    {
        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);

        if ($request->input('starts_on ') != null || $request->input('ends_on') != null ) {
            $this->validate($request, [
                'name'              => 'required|min:2|max:255',
                'description'       => 'required|min:4',
                'starts_on'         => 'date|before_or_equal:ends_on',
                'ends_on'           => 'date|after_or_equal:starts_on',
                'hours'             => 'integer|min:1|max:40'
            ]);

            $sprint->starts_on = $request->input('starts_on');
            $sprint->ends_on = $request->input('ends_on');
        }else {
            $this->validate($request, [
                'name'              => 'required|min:2|max:255',
                'description'       => 'required|min:4',
                'hours'             => 'integer|min:1|max:40'
            ]);

            $sprint->starts_on = $request->input('starts_on');
            $sprint->ends_on = $request->input('ends_on');
        }

        $sprint->name = $request->input('name');
        $sprint->description = Purifier::clean($request->input('description'));
        $sprint->project_id = $project->id;
        $sprint->hours = $request->input('hours');
        $sprint->save();

        Session::flash('success', 'Sprint actualizado sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $sprint_id)
    {
        $sprint = Sprint::find($sprint_id);
        // delete sprint's tasks
        Task::where('sprint_id', $sprint_id)->delete();
        // delete sprint
        $sprint->delete();

        $project = Project::find($project_id);

        Session::flash('success', 'El sprint fue eliminado sin problemas.');
        return redirect()->route('project.show', $project->id);
    }
}
