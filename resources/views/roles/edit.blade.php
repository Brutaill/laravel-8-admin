@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>  
                </div>               
            </div>

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="card">
                <div class="card-header">{{ __('Edit role') }}</div>

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
                            <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" 
                                name="name" 
                                class="form-control" 
                                value="{{ old('name', $role->name) }}" 
                                placeholder="Name" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            />
                            </div>
    
                            <div class="form-group mb-3">
                            <label for="guard_name">Guard name</label>
                            <select type="text" 
                                name="guard_name" 
                                class="form-control">
                                <option value="web" {{ old('guard_name', $role->guard_name) == 'web' ? 'selected':null }}>Web</option>
                                <option value="api" {{ old('guard_name', $role->guard_name) == 'api' ? 'selected':null }}>Api</option>
                            </select>
                            </div>
                            
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