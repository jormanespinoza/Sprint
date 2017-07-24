<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use Illuminate\Http\Request;
use App\Models\Project;
use Session;

class SprintController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $project = Project::find($id);
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
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'name'              => 'required|min:3|max:255',
            'description'       => 'min:4',
            'starts_on'         => 'required|date|after_or_equal:yesterday',
            'ends_on'           => 'required|date|after_or_equal:starts_on'
        ]);

        $project = Project::find($id);

        $sprint = new Sprint;
        $sprint->name = $request->name;
        $sprint->description = $request->description;
        $sprint->project_id = $project->id;
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
    public function show($id, $sprint_id)
    {
        $sprint = Sprint::find($sprint_id);
        $project = Project::find($id);

        return view('sprints.show')
            ->with('sprint', $sprint)
            ->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function edit(Sprint $sprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sprint $sprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sprint $sprint)
    {
        //
    }
}
