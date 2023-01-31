@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="row justify-content-between mb-3">
                <div class="col-4">
                    <a class="btn btn-primary" href="{{ session('clients.currentUrl') }}">Back</a>  
                </div>               
            </div>

            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="card">
                <div class="card-header">{{ __('Edit client') }}</div>

                <div class="card-body">
                    
                    <x-card-errors :error=$errors></x-card-errors>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                            <label for="name">Company</label>
                            <input type="text" 
                                name="name" 
                                class="form-control" 
                                value="{{ old('name') ? old('name') : $client->name }}" 
                                placeholder="Name" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            />
                            </div>
    
                            <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <textarea rows="4"
                                name="address" 
                                class="form-control" 
                                placeholder="Address" 
                                autocomplete="off" 
                                aria-autocomplete="none" 
                            >{!! old('address') ? old('address') : $client->address !!}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="vat">VAT</label>
                                <input type="text" 
                                    name="vat" 
                                    class="form-control" 
                                    value="{{ old('vat') ? old('vat') : $client->vat }}" 
                                    placeholder="VAT" 
                                    autocomplete="off" 
                                    aria-autocomplete="none" 
                                />
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