<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Sprint;
use App\Models\Task;
use Session;
use Purifier;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(6);
        $all_projects = Project::all();

        return view('admin.projects.index')
            ->with('projects', $projects)
            ->with('all_projects', $all_projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('last_name', 'desc')->get();
        // Get all users
        $clients = [];
        $developers = [];
        $leaders = [];

        foreach ($users as $user) {
            if ($user->role_id == 4) {
                $clients[] = $user;
            }
            if ($user->role_id == 3) {
                $developers[] = $user;
            }
            if ($user->role_id == 2) {
                $leaders[] = $user;
            }
        }

        return view('admin.projects.create')
            ->with('clients', $clients)
            ->with('developers', $developers)
            ->with('leaders', $leaders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->develop_url != null && $request->production_url != null) {
            $this->validate($request, [
                'name'          => 'required|string|min:2|max:255',
                'description'   => 'required|min:4',
                'develop_url'   => 'url',
                'production_url'   => 'url'

            ]);
        }

        if ($request->develop_url != null && $request->production_url == null) {
            $this->validate($request, [
                'name'          => 'required|string|min:2|max:255',
                'description'   => 'required|min:4',
                'develop_url'   => 'url'

            ]);
        }

        if ($request->develop_url == null && $request->production_url != null) {
            $this->validate($request, [
                'name'          => 'required|string|min:2|max:255',
                'description'   => 'required|min:4',
                'production_url'   => 'url'
            ]);
        }

        $project = new Project;
        $project->name              = $request->name;
        $project->description       = Purifier::clean($request->description);
        $project->develop_url       = $request->develop_url;
        $project->production_url    = $request->production_url;
        $project->save();

        if ($request->leaders != null || $request->developers != null || $request->clients != null) {
            // Fetch assigned users from form
            $users = [];
            $users = array_merge($request->leaders, $request->developers, $request->clients);

            // sync project/users relationship
            $project->users()->sync($users, false);
        }

        Session::flash('success', 'El proyecto fue generado sin problemas');
        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
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

        // For users asignment
        $users = User::orderBy('last_name', 'desc')->get();
        $fetch_users = $project->users()->orderBy('last_name')->get();

        // Get all users
        $clients = [];
        $developers = [];
        $leaders = [];

        // Get assigned users
        $assigned_users = [];

        foreach ($fetch_users as $user) {
            $assigned_users[$user->id] = $user->last_name. ' ' . $user->first_name;
        }

        foreach ($users as $user) {
            // Get All Users
            if ($user->role_id == 4) {
                $clients[$user->id] = $user->last_name. ' ' . $user->first_name;
            }
            if ($user->role_id == 3) {
                $developers[$user->id] = $user->last_name . ' ' . $user->first_name;
            }
            if ($user->role_id == 2) {
                $leaders[$user->id] = $user->last_name . ' ' . $user->first_name;
            }
        }

        // return view with data
        return view('admin.projects.show')
            ->with('project', $project)
            ->with('assigned_leader', $assigned_leader)
            ->with('assigned_developer', $assigned_developer)
            ->with('assigned_client', $assigned_client)
            ->with('clients', $clients)
            ->with('developers', $developers)
            ->with('leaders', $leaders)
            ->with('users', $assigned_users);
    }

    /**
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $users = User::orderBy('last_name', 'desc')->get();
        $fetch_users = $project->users()->orderBy('last_name')->get();

        // Get all users
        $clients = [];
        $developers = [];
        $leaders = [];

        // Get assigned users
        $assigned_users = [];

        foreach ($fetch_users as $user) {
            $assigned_users[$user->id] = $user->last_name. ' ' . $user->first_name;
        }

        foreach ($users as $user) {
            // Get All Users
            if ($user->role_id == 4) {
                $clients[$user->id] = $user->last_name. ' ' . $user->first_name;
            }
            if ($user->role_id == 3) {
                $developers[$user->id] = $user->last_name . ' ' . $user->first_name;
            }
            if ($user->role_id == 2) {
                $leaders[$user->id] = $user->last_name . ' ' . $user->first_name;
            }
        }

        return view('admin.projects.edit')
            ->with('project', $project)
            ->with('clients', $clients)
            ->with('developers', $developers)
            ->with('leaders', $leaders)
            ->with('users', $assigned_users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->input('develop_url') != null && $request->input('production_url') != null) {
            $this->validate($request, [
                'name'          => 'required|string|min:2|max:255',
                'description'   => 'required|min:4',
                'develop_url'   => 'url',
                'production_url'   => 'url'

            ]);
        }

        if ($request->input('develop_url') != null && $request->input('production_url') == null) {
            $this->validate($request, [
                'name'          => 'required|string|min:2|max:255',
                'description'   => 'required|min:4',
                'develop_url'   => 'url'

            ]);
        }

        if ($request->input('develop_url') == null && $request->input('production_url') != null) {
            $this->validate($request, [
                'name'          => 'required|string|min:2|max:255',
                'description'   => 'required|min:4',
                'production_url'   => 'url'
            ]);
        }

        $project = Project::find($id);
        $project->name              = $request->input('name');
        $project->description       = Purifier::clean($request->input('description'));
        $project->develop_url       = $request->input('develop_url');
        $project->production_url    = $request->input('production_url');
        $project->save();

        // sync project/users relationship
        $project->users()->sync($request->users);

        Session::flash('success', 'El proyecto fue actualizado sin problemas.');
        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function updateAssignedUsers(Request $request, $id)
    {
        $project = Project::find($id);
        // sync project/users relationship
        $project->users()->sync($request->users);

        Session::flash('success', 'El proyecto fue actualizado sin problemas.');
        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        // detach project's users
        $project->users()->detach();
        // delete sprint's tasks
        foreach($projecs->sprints as $sprint) {
            Task::where('sprint_id', $sprint->id)->delete();
        }
        // delete sprint's tasks
        $project->sprints->delete();
        
        // delete project
        $project->delete();

        Session::flash('success', 'El proyecto fue eliminado sin problemas.');
        return redirect()->route('projects.index');
    }
}
