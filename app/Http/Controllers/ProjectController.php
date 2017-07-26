<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        // detect if user belongs to the project
        $checked_user = false;
        foreach($project->users as $user) {
            if (auth()->user()->id == $user->id || auth()->user()->role_id == 1) {
                $checked_user = true;
            }
        }

        if (!$checked_user) {
            return redirect('/dashboard');
        }

        // obtain related users to the project
        $users = $project->users()->orderBy('last_name', 'desc')->get();
        // check if there are assigned users to the project
        $assigned_leader = false;
        $assigned_developer = false;
        $assigned_client = false;

        foreach($users as $user) {
            if ($user->role_id == 2) {
                $assigned_leader = true;
            }
            if ($user->role_id == 3) {
                $assigned_developer = true;
            }
            if ($user->role_id == 4) {
                $assigned_client = true;
            }
        }

        return view('project.show')
            ->with('project', $project)
            ->with('assigned_leader', $assigned_leader)
            ->with('assigned_developer', $assigned_developer)
            ->with('assigned_client', $assigned_client);
    }
}
