@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ session('projects.currentUrl') }}">Back</a>  
                </div>               
            </div>

            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

            <div class="card">
                <div class="card-header">{{ __('Create project') }}</div>

                <div class="card-body">
                    
                    <x-card-errors :error=$errors></x-card-errors>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" 
                                name="title" 
                                class="form-control" 
                                value="{{ old('title') }}" 
                                placeholder="Title" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            />
                            </div>
    
                            <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea rows="10"
                                name="description" 
                                class="form-control" 
                                placeholder="Description" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            >{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="deadline">Deadline</label>
                                <div class="d-flex gap-1">
                                    <input type="date" 
                                        name="deadline_date" 
                                        class="form-control" 
                                        value="{{ old('deadline_date') }}" 
                                        placeholder="date" 
                                        autocomplete="off" 
                                        aria-autocomplete="none" 
                                    />
                                    <input type="time" step="1" 
                                        name="deadline_time" 
                                        class="form-control" 
                                        value="{{ old('deadline_time') }}" 
                                        placeholder="time" 
                                        autocomplete="off" 
                                        aria-autocomplete="none" 
                                    />
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-6">

                            <div class="form-group mb-3">
                                <label for="title">Client</label>
                                <select name="client_id" 
                                    class="form-control"
                                    autocomplete="off" 
                                    readonly="readonly"
                                >
                                    <option value="">-- select client --</option>
                                    @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="title">Users</label>
                                <select name="users[]" multiple style="height: 244px" 
                                    class="form-control"
                                    autocomplete="off" 
                                    readonly="readonly"
                                >
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>                                            

                </div>
                <div class="card-footer">
                    <div class="footer-buttons">
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