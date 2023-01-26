@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ route('users.create') }}">Create user</a>  
                </div>
                <div class="col-6">

                        <form action="{{ route('users.index') }}">
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
                                <div class="col-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                            name="is_admin" 
                                            type="checkbox" 
                                            id="is_admin" 
                                            value="1" 
                                            {{ (request('is_admin') == '1') ? 'checked' : '' }} 
                                            onchange="this.form.submit()"
                                        />
                                        <label class="form-check-label" for="is_admin">Only Admins</label>
                                    </div>
                                </div>
                            </div>                        
                        </form>

                </div>                
            </div>

            <div class="card">                

                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif 
                    
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Projects</th>
                                <th>Is Admin</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->projects_count }}</td>
                                <td>{{ ($user->is_admin == 1) ? 'Admin' : 'Guest' }}</td>
                                <td><div class="flex">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a class="link-primary btn btn-link btn-sm" href="{{ route('users.show', $user->id) }}">show</a>
                                        <a class="link-info btn btn-link btn-sm" href="{{ route('users.edit', $user->id) }}">edit</a>
                                        <button class="link-danger btn btn-link btn-sm" type="submit">delete</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>    
                        @endforeach
                        
                        </tbody>
                    </table>

                    {{ $users->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection