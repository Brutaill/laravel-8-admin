@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ route('clients.create') }}">Create client</a>  
                </div>
                <div class="col-6">

                    <form action="{{ route('clients.index') }}">
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

                <div class="card-header">{{ __('Clients list') }}</div>

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
                                <th>Company</th>
                                <th>VAT</th>
                                <th>Address</th>
                                <th>Projects</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->vat }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->projects_count }}</td>
                                <td><div class="flex">
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Naozaj zmazat {{ $client->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <!--<a class="link-primary btn btn-link btn-sm" href="{{ route('clients.show', $client->id) }}">show</a>-->
                                        <a class="link-info btn btn-link btn-sm" href="{{ route('clients.edit', $client->id) }}">edit</a>
                                        <button class="link-danger btn btn-link btn-sm" type="submit">delete</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>    
                        @endforeach
                        
                        </tbody>
                    </table>

                    {{ $clients->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection