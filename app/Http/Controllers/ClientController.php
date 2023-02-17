<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    
    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $perPage = 6;
        $filters = [
            'search' => $request->search,
        ];

        $clients = Client::withCount('projects')
            ->withCount('tasks')
            ->withUniqueUsers()
            ->orderBy('projects_count','desc')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();

        return view('clients.index', compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    public function archive(Request $request)
    {
        //
        $perPage = 6;
        $filters = [
            'search' => $request->search,
        ];

        $clients = Client::onlyTrashed()->withCount('projects')
            ->withCount('tasks')
            ->withUniqueUsers()
            ->orderBy('projects_count','desc')
            ->filter($filters)
            ->paginate($perPage)
            ->withQueryString();

        return view('clients.archive', compact('clients'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:clients'],
            'address' => ['required'],
            'vat' => ['required'],
        ]);

        $client = Client::create($validated);

        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        
        $client = Client::withCount('projects')
            ->withCount('tasks')
            ->withUniqueUsers()
            ->where('id', $client->id)
            ->get()->first();
        
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'address' => 'required',
            'vat' => 'required'
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('success','Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
        ->with('success','Client deleted successfully.');
    }
}
