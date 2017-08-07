<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\Project;
use App\Models\User;
use App\Models\Status;
use App\Models\Sprint;
use App\Models\Task;
use Session;
use Mail;

class ObservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id, $sprint_id, $task_id)
    {
        $this->validate($request, [
            'comment' => 'required|min:5|max:2000'
        ]);

        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $task = Task::find($task_id);
        $personal = [];

        $observation = new Observation;
        $observation->comment = $request->comment;
        $observation->user_id = $request->user_id;
        $observation->task_id = $task->id;

        if (count($task->observations) % 2 == 0) {
            // fetch project's users
            foreach($project->users as $user) {
                if ($user->role_id == 2) {
                    $personal[] = $user->email;
                }
            }

            $url = '';
            $task_url = config('app.url') . "/project/$project->id/sprint/$sprint->id/task/$task->id";

            $subject = 'Observación del Cliente';
            $message = "<strong>Tarea:</strong> $task->name.<br>
            <strong>Observación del Cliente:</strong> $observation->comment
            <br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";

            $data = [
                'email'=> 'jespinoza@3dlinkweb.com',
                'subject' => $subject,
                'bodyMessage' => $message,
                'personal' => $personal
            ];

            Mail::send('emails.observation', $data, function ($message) use ($data) {
                $message->from($data['email']);
                $message->to($data['personal']);
                $message->subject($data['subject']);
            });
        }

        if (count($task->observations) > 0 && count($task->observations) % 2 != 0) {
            // fetch project's users
            foreach($project->users as $user) {
                if ($user->role_id == 4) {
                    $personal[] = $user->email;
                }
            }

            $url = '';
            $task_url = config('app.url') . "/project/$project->id/sprint/$sprint->id/task/$task->id";

            $subject = 'Respuesta del Líder';
            $message = "<strong>Tarea:</strong> $task->name.<br>
            <strong>Observación del Líder:</strong> $observation->comment
            <br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";

            $data = [
                'email'=> 'jespinoza@3dlinkweb.com',
                'subject' => $subject,
                'bodyMessage' => $message,
                'personal' => $personal
            ];

            Mail::send('emails.observation', $data, function ($message) use ($data) {
                $message->from($data['email']);
                $message->to($data['personal']);
                $message->subject($data['subject']);
            });
        }

        $observation->save();

        Session::flash('success', 'Su comentario fue registrado sin problemas.');
        return redirect()->route('task.show', [$project->id, $sprint->id, $task->id]);
    }
}