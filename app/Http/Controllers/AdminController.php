<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Project;

class AdminController extends Controller
{
    public function getInfo() {
        $users = User::orderBy('last_name', 'desc')->get();
        $projects = Project::orderBy('created_at', 'desc')->paginate(6);
        $all_projects = Project::orderBy('name', 'asc')->get();
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

        return view('admin.dashboard')
            ->with('clients', $clients)
            ->with('developers', $developers)
            ->with('leaders', $leaders)
            ->with('projects', $projects)
            ->with('all_projects', $all_projects);
    }
}
