@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ route('projects.create') }}">Create project</a>  
                </div>
                <div class="col-6">

                        <form action="{{ route('projects.index') }}">
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
                                            name="is_user" 
                                            type="checkbox" 
                                            id="is_user" 
                                            value="1" 
                                            {{ (request('is_user') == '1') ? 'checked' : '' }} 
                                            onchange="this.form.submit()"
                                        />
                                        <label class="form-check-label" for="is_user">With User</label>
                                    </div>
                                </div>
                            </div>                        
                        </form>

                </div>                
            </div>

            <div class="card">                

                <div class="card-header">{{ __('Projects') }}</div>

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
                                <th>Title</th>
                                <th>Description</th>
                                <th>Deadline</th>
                                <th>Users</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($projects as $project)
                            
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $project->title }}</td>
                                <td>{{ substr($project->description, 0, 50) }}</td>
                                <td>{{ $project->deadline }}</td>
                                <td>{{ $project->users_count }}</td>
                                <td><div class="flex">
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <!--<a class="link-primary btn btn-link btn-sm" href="{{ route('projects.show', $project) }}">show</a>-->
                                        <a class="link-info btn btn-link btn-sm" href="{{ route('projects.edit', $project) }}">edit</a>
                                        <button class="link-danger btn btn-link btn-sm" type="submit">delete</button>
                                    </form>
                                    </div>
                                </td>
                            </tr> 
                            
                        @endforeach
                        
                        </tbody>
                    </table>

                    {{ $projects->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection