<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Project;

class DashboardController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_role = Auth::user()->role_id;
        $role = Role::where('id', $user_role)->first();
        $role_name = $role->name;

        // redirect with data if the user is an admin
        if ($user_role == 1) {
            $users = User::orderBy('last_name', 'desc')->get();
            $projects = Project::orderBy('name', 'asc')->paginate(6);
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

            return redirect()->to('admin')
                ->with('clients', $clients)
                ->with('developers', $developers)
                ->with('leaders', $leaders)
                ->with('projects', $projects);
        }

        // redirect to users' dashboard
        return view('dashboard')
            ->with('role', $role_name);
    }
}
