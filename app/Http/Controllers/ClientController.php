<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::all();
        return $clients;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'CIN'=>'required|string|unique:clients,CIN',
            'nom'=>'required|string',
            'prenom1'=>'required|string',
            'prenom2'=>'nullable',
            'adresse'=>'required|string',
            'telephone'=>'required|string|unique:clients,telephone',
            'profession'=>'required|string'
        ]);
        return Client::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
        return $client;
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
        //
        $data = $request->validate([
            'CIN'=>'required|string',
            'nom'=>'required|string',
            'prenom1'=>'required|string',
            'prenom2'=>'nullable',
            'adresse'=>'required|string',
            'telephone'=>'required|string',
            'profession'=>'required|string'
        ]);
        $client->update($data);
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
        $client->delete();
    }
}
