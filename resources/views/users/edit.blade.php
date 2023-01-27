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

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif  
                    
                    <div class="row">
                        <div class="col-6">
                            
                            <div class="form-group mb-3 form-check">
                                <input type="checkbox" 
                                    class="form-check-input" 
                                    name="is_admin" 
                                    value="1" 
                                    id="is_admin" 
                                    {{ (!empty(old('is_admin', $user->is_admin))) ? 'checked':null }}
                            />
                            <label class="form-check-label" for="is_admin">Is Admin</label>
                            </div>
                            
                            <div class="form-group mb-3">
                            <label for="name">Meno</label>
                            <input type="text" 
                                name="name" 
                                class="form-control" 
                                value="{{ old('name', $user->name) }}" 
                                placeholder="Name" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            />
                            </div>
    
                            <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" 
                                name="email" 
                                class="form-control" 
                                value="{{ old('email', $user->email) }}" 
                                placeholder="Email" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            />
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Role</label>
                                <select name="role_id" class="form-control">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <fieldset>
                                <legend>
                                    <input type="checkbox" name="password_change" id="change_password" value="A" />
                                    <label for="change_password">Change password</label>   
                                </legend>
                                <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" 
                                    name="password" 
                                    class="form-control" 
                                    value="" 
                                    autocomplete="password-current" 
                                    aria-autocomplete="none" 
                                />
                                </div>
        
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Password confirmation</label>
                                    <input type="password" 
                                        name="password_confirmation" 
                                        class="form-control" 
                                        value="" 
                                        autocomplete="password_confirmation-current" 
                                        aria-autocomplete="none" 
                                    />
                                </div>
                            </fieldset>    
                            
                        </div>

                        <div class="col-6">
                            <fieldset>
                                <legend>Projects</legend>
                                <div>

                                    @foreach($projects as $project)
                                        <div>
                                            <div><input 
                                                    id="project_{{ $project->id }}" 
                                                    name="projects[]" 
                                                    value="{{ $project->id }}" 
                                                    type="checkbox"
                                                    {{ (in_array($project->id, $userProjects)) ? 'checked' : null }}
                                                />
                                            <label for="project_{{ $project->id }}">{{ $project->title }}</label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </fieldset>
                            
                        </div>
                    </div>

                                            

                </div>
                <div class="card-footer">
                    <div>
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection