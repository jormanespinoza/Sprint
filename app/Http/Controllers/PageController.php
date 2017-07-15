<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use Purifier;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('getIndex');
    }

    public function getIndex()
    {
        return view('pages.welcome');
    }

    public function getContact()
    {
        return view('pages.contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required|min:4'
        ]);

        $data = [
            'email'=> $request->email,
            'subject' => $request->subject,
            'bodyMessage' => Purifier::clean($request->message)
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('espinoza-dev@gmail.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Tu mensaje ha sido enviado con éxito!');
        if (auth()->user()->role_id == 1) {
            return redirect('/admin');
        }
        return redirect('/dashboard');
    }
}
