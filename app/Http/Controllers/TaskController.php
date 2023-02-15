<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Notifications\TaskComplete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $perPage = 6;
        $filters = [];
        $tasks = Task::select(['*'])
                ->addSelect(['user_name' => User::select('name')
                    ->whereColumn('users.id', 'tasks.user_id')->withTrashed()                  
                    ])
                ->addSelect(['project_title' => Project::select('title')           
                    ->whereColumn('projects.id', 'tasks.project_id')->withTrashed()                    
                    ])
                ->filter($filters)
                ->orderBy('completed_at')
                ->paginate($perPage)
                ->withQueryString();

        return view('tasks.index', compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {

        $perPage = 6;
        $filters = [];
        $tasks = Task::select(['*'])->onlyTrashed()
                ->addSelect(['user_name' => User::select('name')
                    ->whereColumn('users.id', 'tasks.user_id')->withTrashed()                  
                    ])
                ->addSelect(['project_title' => Project::select('title')           
                    ->whereColumn('projects.id', 'tasks.project_id')->withTrashed()                    
                    ])
                ->filter($filters)
                ->orderBy('completed_at')
                ->paginate($perPage)
                ->withQueryString();

        return view('tasks.archive', compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $auth = User::find(auth()->id());
        
        // auth user projects
        $userProjects = Project::whereHas('users', function($query) use($auth) {
            if($auth->hasPermissionTo('task_update')) {
                $query->where('id', auth()->id());
            }
        })->get(['id', 'title']);
        
        return view('tasks.create', compact('userProjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'description' => 'required|max:1024',
        ]);

        $validated['client_id'] = Project::findOrFail($validated['project_id'])->client()->first()->id;
        $validated['user_id'] = auth()->id();

        $task = Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task was created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'description' => 'required',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task was updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, Task $task)
    {
        
        $this->authorize('complete', $task);
        
        $task->update([
            'completed_at' => now()
        ]);

        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'Super Admin');
        })->get();

        if($users) {
            Notification::sendNow($users, new TaskComplete($task));
        }

        return back()->with('success', 'Task was completed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Task was deleted successfully');
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function restore(Task $task)
    {
        $task->restore();

        return back()->with('success', 'Task was restored successfully');
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Task $task)
    {
        $task->forceDelete();

        return back()->with('success', 'Task was deleted from DB successfully');
    }
}
