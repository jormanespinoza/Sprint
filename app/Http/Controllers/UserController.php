<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('last_name', 'asc')->paginate(10);
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('users.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate user's fields
        $this->validate($request, [
            'first_name'    => 'required|string|alpha|max:255',
            'last_name'     => 'required|string|alpha|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'role_id'       => 'required',
            'password'      => 'required|string|min:6|confirmed',
        ]);

        // create user
        $user = new User;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email        = $request->email;
        $user->role_id      = $request->role_id;
        $user->password     = bcrypt($request->password);

        // save user
        $user->save();

        // send notification and redirects to a view
        Session::flash('success', 'El usuario ha sido creado satistoriamente.');
        return redirect()->route('users.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('id', 'desc')->get();
        // generate an associative array for select field
        $roles_fetch = [];
        foreach($roles as $role) {
            $roles_fetch[$role->id] = $role->name;
        }

        return view('users.edit')
            ->with('user', $user)
            ->with('roles', $roles_fetch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate user's fields
        $this->validate($request, [
            'first_name'    => 'required|string|alpha|max:255',
            'last_name'     => 'required|string|alpha|max:255'
        ]);

        // update user
        $user = User::find($id);
        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->role_id      = $request->input('role_id');
        $user->save();

        // redirect and send notification
        Session::flash('success', 'Usuario actualizado sin problemas.');
        return redirect()->route('users.show', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
