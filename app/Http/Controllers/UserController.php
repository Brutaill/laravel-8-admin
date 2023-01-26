<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
            'is_admin' => $request->is_admin,
        ];

        $users = User::withCount('projects')
            ->orderBy('projects_count', 'desc')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();

        // put full urll in the session
        session()->put('users.currentUrl', request()->fullUrl());

        return view('users.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        return view('users.create', compact('projects'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);        
        
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => $request->input('is_admin') && 0,
        ]);

        // sync user projects in pivot table
        $user->projects()->sync($request->input('projects'), true);
        
        return redirect()->to(session('users.currentUrl'))
            ->with('success','User created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // all project for checklist
        $projects = Project::all();

        // all related user projects
        $userProjects = $user->projects->pluck('id')->all();

        return view('users.edit', compact(
            'user',
            'userProjects',
            'projects'
        ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);   
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin ?? 0,
        ]);

        if($request->has('password_change')) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        } 
        
        // sync user projects in pivot table
        $user->projects()->sync($request->input('projects'), true);

        return redirect()->to(session('users.currentUrl'))
            ->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = User::find($user->id)->delete();

        return redirect()->to(session('users.currentUrl'))
            ->with('success','User deleted successfully.');
    }
}
