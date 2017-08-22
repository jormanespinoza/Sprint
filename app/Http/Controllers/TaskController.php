<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\User;
use App\Models\Status;
use App\Models\Observation;
use Mail;
use Session;
use Purifier;
use Config;

class TaskController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id, $sprint_id)
    {
        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $developers = [];
        $leaders = [];
        $hours = [1,2,3,5,8,13];
        $task_hours = [];
        $tasks = $sprint->tasks;
        $task_total_hours = 0;

        if (count($tasks) > 0) {
            $all_tasks_confirmed = true;
            foreach($tasks as $task) {
                $task_total_hours += $task->hours;
            }
        }

        foreach($task_hours as $hour) {
            if ($hour <= $sprint->hours - $task_total_hours) {
                $task_hours[$hour] = $hour;
            }
        }

        $user_as_developer = false;
        $user_as_leader = false;

        // fetch project's users
        foreach($project->users as $user) {
            if ($user->role_id == 3) {
                $developers[] = $user;
                $user_as_developer = true;
            }
            if ($user->role_id == 2) {
                $leaders[] = $user;
                $user_as_leader = true;
            }
        }

        if ($user_as_developer && !$sprint->done) {
            // check if the developer belongs to the project, so he could create new sprints and tasks
            foreach($developers as $developer) {
                if (auth()->user()->id == $developer->id) {
                    return view('sprints.show')
                        ->with('user', $developer)
                        ->with('sprint', $sprint)
                        ->with('hours', $task_hours)
                        ->with('project', $project);
                }
            }
        }

        if ($user_as_leader && !$sprint->done) {
            // check if the developer belongs to the project, so he could create new sprints and tasks
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('sprints.show')
                        ->with('user', $leader)
                        ->with('sprint', $sprint)
                        ->with('hours', $task_hours)
                        ->with('project', $project);
                }
            }
        }

        // return to dashboard if this developer or user does not belong to the project
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id, $sprint_id)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:255'
        ]);

        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $task = new Task;

        // save task data
        $task->name = $request->name;
        $task->hours = $request->hours;
        $task->sprint_id = $sprint->id;

        $task->save();

        // send an email with a notification
        $personal = [];

        // fetch project's users
        foreach($project->users as $user) {
            if ($user->role_id == 2) {
                $personal[] = $user->email;
            }
        }

        $url = '';
        $task_url = config('app.url') . "/project/$project->id/sprint/$sprint->id/task/$task->id";

        $subject = 'Tarea Creada';
        $message = "La tarea <strong>$task->name</strong> fue generada en el sistema y se encuentra a la espera de aprobación.<br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";

        $data = [
            'email'=> 'info@3dlinkweb.com',
            'subject' => $subject,
            'bodyMessage' => $message,
            'personal' => $personal
        ];

        Mail::send('emails.observation', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to($data['personal']);
            $message->subject($data['subject']);
        });

        Session::flash('success', 'La tarea del sprint fue creada sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Taskt  $stask
     * @return \Illuminate\Http\Response
     */
    public function show($project_id, $sprint_id, $task_id)
    {
        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $task = Task::find($task_id);

        return view('tasks.show')
            ->with('task', $task)
            ->with('sprint', $sprint)
            ->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($project_id, $sprint_id, $task_id)
    {
        $task = Task::find($task_id);
        $sprint = Sprint::find($sprint_id);
        $project = Project::find($project_id);

        $leaders = [];
        $developers = [];

        $there_are_leaders = false;
        $there_are_developers = false;

        // fetch project's developers and leaders
        foreach($project->users as $user) {
            if ($user->role_id == 2) {
                $leaders[] = $user;
                $there_are_leaders = true;
            }
            if ($user->role_id == 3) {
                $developers[] = $user;
                $there_are_developers = true;
            }
        }

        // check user role
        if ($there_are_leaders) {
            foreach($leaders as $leader) {
                if (auth()->user()->id == $leader->id) {
                    return view('tasks.edit')
                        ->with('task', $task)
                        ->with('sprint', $sprint)
                        ->with('user', $leader)
                        ->with('project', $project);
                }
            }
        }

        if ($there_are_developers) {
            foreach($developers as $developer) {
                if (auth()->user()->id == $developer->id) {
                    return view('tasks.edit')
                        ->with('task', $task)
                        ->with('sprint', $sprint)
                        ->with('user', $developer)
                        ->with('project', $project);
                }
            }
        }

        // return to sprint if this developer or user does not belong to the project
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, $sprint_id, $task_id)
    {
        $project = Project::find($project_id);
        $sprint = Sprint::find($sprint_id);
        $task = Task::find($task_id);
        $email = Config::get('mail.username');
        $personal = [];
        $leaders = [];
        $developers = [];
        $clients = [];
        $observation = '';
        

        if ($request->input('changing_status') || $request->editedByLeader || $request->input('status_id') == 6) {
            $task->status_id = $request->input('status_id');

            // fetch project's users
            foreach($project->users as $user) {
                if ($user->role_id == 2) {
                    $leaders[] = $user->email;
                }
                if($user->role_id == 3) {
                    $developers[] = $user->email;
                }
                if($user->role_id == 4) {
                    $clients[] = $user->email;
                }
            }

            $url = '';
            $task_url = config('app.url') . "/project/$project->id/sprint/$sprint->id/task/$task->id";

            if ($task->status_id == 2) {
                $subject = 'Tarea Aprobada';
                $message = "La tarea <strong>$task->name</strong> fue aprobada por el líder de proyecto.<br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";
            }

            if ($task->status_id == 3) {
                if ($request->input('observation') != null) {
                    $subject = 'Tarea En Revisión (Observación añadida)';
                    $observation = $request->input('observation');
                    $message = "La tarea <strong>$task->name</strong> fue gestionada, la misma se encuentra en revisión.<br>
                    <strong>Observación:</strong> $observation
                    <br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";

                    // create observation
                    $observation = new Observation;
                    $observation->comment = $request->input('observation');
                    $observation->user_id = auth()->user()->id;
                    $observation->task_id = $task->id;
                    $observation->save();
                }else {
                    $subject = 'Tarea En Revisión';
                    $message = "La tarea <strong>$task->name</strong> fue gestionada, la misma se encuentra en revisión.<br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";
                }
            }

            if ($task->status_id == 4) {
                $subject = 'Tarea Devuelta';
                $observation = $request->input('observation');
                $message = "La tarea <strong>$task->name</strong> fue devuelta por el líder de proyecto.<br>
                <strong>Observación:</strong> $observation
                <br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";
                // create observation
                $observation = new Observation;
                $observation->comment = $request->input('observation');
                $observation->user_id = auth()->user()->id;
                $observation->task_id = $task->id;
                $observation->save();
            }

            if ($task->status_id == 5) {
                if ($request->input('observation') != null) {
                    $subject = 'Tarea Confirmada (Observación añadida)';
                    $observation = $request->input('observation');
                    $message = "La tarea <strong>$task->name</strong> fue confirmada.<br>
                    <strong>Observación:</strong> $observation
                    <br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";
                    // create observation
                    $observation = new Observation;
                    $observation->comment = $request->input('observation');
                    $observation->user_id = auth()->user()->id;
                    $observation->task_id = $task->id;
                    $observation->save();
                }else {
                    $subject = 'Tarea Confirmada';
                    $message = "La tarea <strong>$task->name</strong> fue confirmada.<br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";
                }

                $subject2 = 'Tarea Completada';
                $message2 = "La tarea <strong>$task->name</strong> fue sido completada.<br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ver Tarea</a>";

                $data2client = [
                    'email'=> 'info@3dlinkweb.com',
                    'subject' => $subject2,
                    'bodyMessage' => $message2,
                    'clients' => $clients
                ];

                // send an email with a notification to the client(s)
                Mail::send('emails.observation', $data2client, function ($message) use ($data2client) {
                    $message->from($data2client['email']);
                    $message->to($data2client['clients']);
                    $message->subject($data2client['subject']);
                });
            }

            if ($task->status_id == 6) {
                $subject = 'Tarea Reactivada';
                $observation = $request->input('observation');
                $message = "La tarea <strong>$task->name</strong> fue reactivada por el líder de proyecto.<br>
                <strong>Observación:</strong> $observation
                <br><br><a class=\"btn btn-primary\" href=\"$task_url\"><span class=\"glyphicon glyphicon-export\"></span> Ir a la Tarea</a>";
                $task->status_id = 2;
            }
            
            switch ($task->status_id) {
                case 2:
                    $personal = $developers;
                    break;
                case 3:
                    $personal = $leaders;
                    break;
                case 4:
                    $personal = $developers;
                    break;
                case 5:
                    $personal = $developers + $leaders;
                    break;
                case 6:
                    $personal = $developers;
                    break;
                default:
                    break;
            }

            $data = [
                'email'=> 'info@3dlinkweb.com',
                'subject' => $subject,
                'bodyMessage' => $message,
                'personal' => $personal
            ];
            // send an email with a notification
            Mail::send('emails.observation', $data, function ($message) use ($data) {
                $message->from($data['email']);
                $message->to($data['personal']);
                $message->subject($data['subject']);
            });
        }else {
            if ($task->status_id == 1 || auth()->user()->role_id == 2) {
                $this->validate($request, [
                    'name'          => 'required|min:2|max:255'
                ]);

                $task->name = $request->input('name');
                $task->hours = $request->input('hours');
                $task->description = Purifier::clean($request->input('description'));
            }else {
                $task->description = Purifier::clean($request->input('description'));
            }
        }

        if ($request->editedByLeader) {
            $this->validate($request, [
                'name' => 'required|min:2|max:255'
            ]);

            $task->name = $request->input('name');
            $task->hours = $request->input('hours');
            $task->description = Purifier::clean($request->input('description'));
            $task->status_id = $request->input('status_id');
        }

        // save task data
        $task->save();

        Session::flash('success', 'La tarea "' . $task->name . '" del sprint fue actualizada sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $sprint_id, $task_id)
    {
        $task = Task::find($task_id);
        $sprint = Sprint::find($sprint_id);

        $task->delete();

        $project = Project::find($project_id);

        Session::flash('success', 'La tarea fue eliminada sin problemas.');
        return redirect()->route('sprint.show', [$project->id, $sprint->id]);
    }
}
