@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ route('roles.create') }}">Create role</a>  
                </div>
                <div class="col-6">

                    <form action="{{ route('roles.index') }}">
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

                <div class="card-header">{{ __('Roles list') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
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

                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>

                                <td><div class="flex">
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Naozaj zmazat {{ $role->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <!--<a class="link-primary btn btn-link btn-sm" href="{{ route('roles.show', $role->id) }}">show</a>-->
                                        <a class="link-info btn btn-link btn-sm" href="{{ route('roles.edit', $role->id) }}">edit</a>
                                        <button class="link-danger btn btn-link btn-sm" type="submit">delete</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>    
                        @endforeach
                        
                        </tbody>
                    </table>

                    {{ $roles->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection