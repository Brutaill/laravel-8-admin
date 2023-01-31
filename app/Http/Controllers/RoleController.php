<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
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
        
        $role = Role::create($validated);

        return redirect()->route('roles.index')
            ->with('status', 'Role was created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::select('id','name')->orderBy('name')->get();        
        $rolePermissions = $role->permissions->pluck('id', 'name')->all();        
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
            'permissions' => 'array',
        ]);
        
        $role->update($validated);
        $role->syncPermissions([$validated['permissions'] ?? []]);

        return redirect()->route('roles.index')
            ->with('status', 'Role was updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index');
    }
}
