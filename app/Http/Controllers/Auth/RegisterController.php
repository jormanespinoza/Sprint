<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $roles_fetch = [];
        foreach($roles as $role) {
            if ($role->id != 1) {
                $roles_fetch[$role->id] = $role->name;
            }
        }
        return view("auth.register")->with('roles', $roles_fetch);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // create new user
        $user = new User;
        $user->first_name   = $data['first_name'];
        $user->last_name    = $data['last_name'];
        $user->email        = $data['email'];
        $user->role_id      = $data['role_id'];
        $user->password     = bcrypt($data['password']);

        // save user
        $user->save();

        // create user profile
        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();

        // send notification and redirects to a view
        Session::flash('success', 'Bienvenido a 3D Sprint!');
        return $user;
    }
}