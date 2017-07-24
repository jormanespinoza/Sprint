<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Session;

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
        $developers = [];

        // fetch project's developers
        foreach($project->users as $user) {
            if ($user->role_id == 3) {
                $developers[] = $user;
            }
        }

        // check if the developer belongs to the project, so he could create new sprints
        foreach($developers as $developer) {
            if (auth()->user()->id == $developer->id) {
                return view('sprints.create')
                    ->with('developer', $developer)
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
    public function store(Request $request, $project_id)
    {
        $this->validate($request, [
            'name'              => 'required|min:2|max:255',
            'description'       => 'min:4',
            'starts_on'         => 'required|date|after_or_equal:yesterday',
            'ends_on'           => 'required|date|after_or_equal:starts_on'
        ]);

        $project = Project::find($project_id);

        $sprint = new Sprint;
        $sprint->name = $request->name;
        $sprint->description = $request->description;
        $sprint->project_id = $project->id;
        $sprint->user_id = $request->user_id;
        $sprint->starts_on = $request->starts_on;
        $sprint->ends_on = $request->ends_on;
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

        // check user role
        if ($there_are_leaders) {
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('sprints.show')
                        ->with('sprint', $sprint)
                        ->with('user', $leader)
                        ->with('project', $project)
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
                        ->with('editor', $editor);
                }
            }
        }

        // return to dashboard if this developer or user does not belong to the project
        return redirect('/login');
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
            if ($user->role_id == 3) {
                $developers[] = $user;
                $there_are_developers = true;
            }
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

        // return to dashboard if this developer or user does not belong to the project
        return redirect('/login');
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
        $this->validate($request, [
            'name'              => 'required|min:2|max:255',
            'description'       => 'min:4',
            'starts_on'         => 'required|date|after_or_equal:yesterday',
            'ends_on'           => 'required|date|after_or_equal:starts_on'
        ]);

        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);

        // chech if the sprint is being edited by a project leader
        if($request->input('user_id') != $sprint->user_id) {
            $sprint->edited = true;
            $sprint->edited_by = $request->input('user_id');
        }

        $sprint->name = $request->input('name');
        $sprint->description = $request->input('description');
        $sprint->project_id = $project->id;
        $sprint->user_id = $sprint->user_id;
        $sprint->starts_on = $request->input('starts_on');
        $sprint->ends_on = $request->input('ends_on');
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
        $sprint->delete();

        $project = Project::find($project_id);

        Session::flash('success', 'El sprint fue eliminado sin problemas.');
        return redirect()->route('project.show', $project->id);
    }
}
