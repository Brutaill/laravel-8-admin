@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ route('permissions.create') }}">Create permission</a>  
                </div>
                <div class="col-6">

                    <form action="{{ route('permissions.index') }}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <input 
                                    name="search" 
                                    type="text" 
                                    class="form-control" 
                                    value="{{ (request('search')) ?? '' }}"
                                    onchange="this.form.submit()"
                                />
                            </div>
                        </div>                        
                    </form>

                </div>                
            </div>

            <div class="card">                

                <div class="card-header">{{ __('Permissions list') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" permission="alert">
                            {{ session('success') }}
                        </div>
                    @endif 
                    
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Guard name</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>

                                <td><div class="flex">
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Naozaj zmazat {{ $permission->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <!--<a class="link-primary btn btn-link btn-sm" href="{{ route('permissions.show', $permission->id) }}">show</a>-->
                                        <a class="link-info btn btn-link btn-sm" href="{{ route('permissions.edit', $permission->id) }}">edit</a>
                                        <button class="link-danger btn btn-link btn-sm" type="submit">delete</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>    
                        @endforeach
                        
                        </tbody>
                    </table>

                    {{ $permissions->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection