<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
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
            'is_admin' => $request->is_admin,
        ];

        $users = User::withCount('projects','tasks')
            ->orderBy('projects_count', 'desc')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();


        return view('users.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
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
    public function store(UserStoreRequest $request)
    {
        
        $validated = $request->validated();        

        $validated['password'] = Hash::make($validated->safe('password'));
        $validated['is_admin'] = $validated->safe('is_admin') && 0;
        
        $user = User::create($validated);
        
        return redirect()->route('users.index')
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
        
        // all roles for checklist
        $roles = Role::orderBy('name')->get();        
        // all project for checklist
        $projects = Project::orderBy('title')->get();
        // all user projects
        $userProjects = $user->projects->pluck('id')->all();
        // all user roles
        $userRoles = $user->roles()->pluck('id')->all(); 

        return view('users.edit', compact(
            'user',
            'userProjects',
            'userRoles',
            'roles',
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
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill($validated)->save();   

        return redirect()->route('users.index')
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
        
        if(auth()->user()->id == $user->id) {
            return redirect()->route('users.index')
                ->with('warning','User can not by deleted.');
        } else {
            
            $user->delete();

            return redirect()->route('users.index')
                ->with('success','User deleted successfully.');
        }        
    }


    public function passwordChange(Request $request, User $user)
    {
        
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update($validated);
        
        return redirect()->route('users.edit', compact('user'))
            ->with('success','Password was updated successfully.');
    }


    public function projectsAssign(Request $request, User $user)
    {

        $user->projects()->sync($request->input('projects'), true);
        
        return redirect()->route('users.edit', compact('user'))
            ->with('success','Projects was updated successfully.');
    }
}
