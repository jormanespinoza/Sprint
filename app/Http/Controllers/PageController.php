<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;

class PageController extends Controller
{
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
            'message' => 'required'
        ]);

        $data = [
            'email'=> $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('espinoza-dev@gmail.com');
            $message->subject($data['subject']);
        }); // Mail:queue();

        Session::flash('success', 'Tu mensaje ha sido enviado con éxito!');
        return redirect('/');
    }
}
