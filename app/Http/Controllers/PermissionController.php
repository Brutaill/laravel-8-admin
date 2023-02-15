<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
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
        ];

        $permissions = Permission::orderBy('name')
            ->when($filters['search'] ?? false, function($query) use($filters) {
                $query->where('name', 'like', '%'.$filters['search'].'%');
            })
            ->paginate($perPage)
            ->withQueryString();

        return view('permissions.index', compact('permissions'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->validate([
            'name' => 'required|unique:permissions',
            'guard_name' => 'required',
        ]));

        return redirect()->route('permissions.index')
            ->with('success', 'Permission was created succesfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->validate([
            'name' => ['required', Rule::unique('permissions', 'name')->ignore($permission->id)],
            'guard_name' => 'required',
        ]));

        return redirect()->route('permissions.index')
            ->with('success', 'Permission was updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        
        if(in_array($permission->name, User::find(auth()->id())->getAllPermissions()->pluck('name')->toArray()) || $permission->name == 'all') {
            return redirect()->route('permissions.index')
                ->with('success', 'Permission cannot by deleted, currently in use');
        }
        
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission was deleted succesfully');
    }
}
