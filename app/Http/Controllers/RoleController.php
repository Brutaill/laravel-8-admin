<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
   
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 10;
        $roles = Role::orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('roles.index', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
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
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ]);
        
        Role::create($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role was created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::select('id','name')->orderBy('name')->pluck('name','id')->all();        
        $rolePermissions = $role->permissions->pluck('name', 'id')->all();        
        return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {        
        $validated = $request->validate([
            'name' => ['required', 'string:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'guard_name' => 'required|string:255', 
        ]);
        
        $role->update($validated);

        return redirect()->route('roles.edit', $role->id)
            ->with('success', 'Role was updated succesfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function assignPermissions(Request $request, Role $role)
    {      

        $role->syncPermissions([$request['permissions'] ?? []]);

        return redirect()->route('roles.edit', $role->id)
            ->with('success', 'Role permissions was updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        
        if(in_array($role->name, User::find(auth()->id())->roles->pluck('name')->toArray())) {
            return redirect()->route('roles.index')
                ->with('success', 'Role cannot by deleted, currently in use');
        }
        
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role was deleted succesfully');
    }
}
