<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use Session;
use Mail;
use Propaganistas\LaravelIntl\Facades\Country;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(10);
        $all_users = User::all();

        return view('admin.users.index')
            ->with('users', $users)
            ->with('all_users', $all_users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('admin.users.create')->with('roles', $roles);
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
        $user->remember_token = $request['_token'];

        // save user
        $user->save();

        // create user profile
        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();

        // send email to new user
        $url = config('app.url');
        $subject = '3D Sprint - Nuevo usuario registrado';
        $message = "Hola $request->first_name,<br><br>
        Hemos generado un nuevo usuario para ti en la aplicación <a href=\"$url\">3D Sprint</a>, éstas son tus credenciales:<br><br>
        <ul style=\"list-style: none;\" >
        <li><strong>Usuario:</strong> $request->email</li>
        <li><strong>Contraseña:</strong> $request->password</li>
        </ul><br><br>
        <a class=\"btn btn-primary\" href=\"$url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a 3D Sprint</a>";

        $data = [
            'email'=> 'info@3dlinkweb.com',
            'subject' => $subject,
            'bodyMessage' => $message,
            'user' =>  $request->email
        ];
        // send an email with a notification
        Mail::send('emails.new_user', $data, function ($message) use ($data) {
        $message->from($data['email']);
        $message->to($data['user']);
        $message->subject($data['subject']);
        });

        // send notification and redirects to a view
        Session::flash('success', 'El usuario ha sido creado satisfactoriamente.');
        return redirect()->route('users.index');
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
        return view('admin.users.show')->with('user', $user);
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
        $profile = $user->profile;

        // generate an associative array for select field
        $roles_fetch = [];
        foreach($roles as $role) {
            $roles_fetch[$role->id] = $role->name;
        }

        return view('admin.users.edit')
            ->with('user', $user)
            ->with('profile', $profile)
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
        $user = User::find($id);

        // validate user's fields
        if ($user->email != $request->input('email')) {
            $this->validate($request, [
                'first_name'    => 'required|string|alpha|max:255',
                'last_name'     => 'required|string|alpha|max:255',
                'email'         => 'required|string|email|max:255|unique:users'
            ]);
            $user->email    = $request->input('email');
        }

        $this->validate($request, [
            'first_name'    => 'required|string|alpha|max:255',
            'last_name'     => 'required|string|alpha|max:255',
        ]);

        // update user
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
        $user = User::find($id);
        $profile = $user->profile;
        $user->projects()->detach();
        $profile->delete();
        $user->delete();

        Session::flash('success', 'El usuario fue eliminado de manera exitosa.');
        return redirect()->route('users.index');
    }
}