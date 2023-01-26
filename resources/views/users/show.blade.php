@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ session('users.currentUrl') }}">Back</a>  
                </div>               
            </div>


            <div class="card">
                <div class="card-header">{{ __('Add User') }}</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <div>Name: {{ $user->name }}</div>
                            <div>Email: {{ $user->email }}</div>
                            <div>Is Admin: {{ $user->is_admin }}</div>
                        </div>
                        <div class="col-6">
                            @if($user->projects->count() > 0)
                            <h3>Projects</h3>    
                            <ul>
                                @foreach ($user->projects as $i => $project)
                                    <li>{{ ++$i }} - {{ $project->title }}</li>    
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <a class="btn btn-success" href="{{ route('users.edit', $user->id) }}">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection