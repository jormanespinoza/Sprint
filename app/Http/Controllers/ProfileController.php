<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Propaganistas\LaravelIntl\Facades\Country;

class ProfileController extends Controller
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
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (auth()->user()->id == $user->id) {
            return view('profile.show')->with('user', $user);
        }
        return redirect('/login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $profile = $user->profile;
        if (auth()->user()->id == $user->id) {
            return view('profile.edit')
                ->with('user', $user)
                ->with('profile', $profile);
        }
        return redirect('/login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $profile = $user->profile;

        // validate user's fields
        if ($request->input('phone') != null) {
            $this->validate($request, [
                'phone' => 'phone:VE,US,CL,CO'
            ]);
        }

        // update user's profile
        $profile->phone = $request->input('phone');
        $profile->bio = $request->input('bio');
        $profile->save();

        // redirect and send notification
        Session::flash('success', 'Usuario actualizado sin problemas.');
        // check if the auth user it's an admin or not
        if(auth()->user()->role_id == 1) {
            return redirect()->route('users.show', $user->id);
        }
        return redirect()->route('profile.show', $user->id);
    }
}
