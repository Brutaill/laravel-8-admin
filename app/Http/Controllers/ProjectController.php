<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProjectUpdateRequest;

class ProjectController extends Controller
{
    
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $perPage = 10;
        $filters = [
            'search' => $request->search,
            'is_user' => $request->is_user,
        ];

        $projects = Project::withCount('users','tasks')
            ->orderBy('deadline','asc')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();

        return view('projects.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $clients = Client::orderBy('name')->get(['id', 'name']);
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('projects.create', compact('clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline_date' => 'required|date|after:yesterday|date_format:Y-m-d',
            'deadline_time' => 'required|date_format:H:i:s',
            'client_id' => 'required',            
        ]);

        $project = Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline_date').' '.$request->input('deadline_time'),
            'client_id' => $request->input('client_id'),
        ]);

        $project->users()->sync($request->input('users'), true);

        return redirect()->route('projects.index')
            ->with('success','Project was created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $this->authorize('project_view');

        $tasks = $project->tasks;
        $users = $project->users;
        
        return view('projects.show', compact('project', 'tasks', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {       
        
        $clients = Client::orderBy('name')->get(['id', 'name']);
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('projects.edit', compact('project', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline_date' => 'required|date|date_format:Y-m-d',
            'deadline_time' => 'required|date_format:H:i:s',
        ]);

        $project->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline_date').' '.$request->input('deadline_time'),
        ]);

        $project->users()->sync($request->input('users'), true);

        return redirect()->route('projects.index')
            ->with('success','Project was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        
        return redirect()->route('projects.index')
            ->with('success','Project was deleted successfully.');
    }
}
