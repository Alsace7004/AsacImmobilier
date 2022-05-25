<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use Illuminate\Http\Request;

class VisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $visites = Visite::all();
        return $visites;
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
            'remarque_client'=>'required|string',
            'client_id'=>'required|integer',
            'appartement_id'=>'required|integer'
        ]);
        return Visite::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function show(Visite $visite)
    {
        //
        return $visite;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visite $visite)
    {
        //
        $data = $request->validate([
            'remarque_client'=>'required|string',
            'client_id'=>'required|integer',
            'appartement_id'=>'required|integer'
        ]);
        $visite->update($data);
        return $visite;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visite  $visite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visite $visite)
    {
        //
        return $visite->delete();
    }
}
