<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisiteController extends Controller
{
    public function visiteCount(){
        $nbr_visites = DB::SELECT('SELECT COUNT(*) as nbr_total_visite FROM visites');
        return $nbr_visites;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$visites = Visite::all();
        $visites = DB::SELECT("SELECT 
        visites.id,visites.created_at,visites.remarque_client,
        clients.nom,clients.prenom1,
        CONCAT(appartements.numero,' / ',immeubles.nom) as appartement_immeuble,
        appartements.numero 
        FROM `visites`,clients,appartements,immeubles 
        WHERE visites.client_id=clients.id and visites.appartement_id = appartements.id and appartements.immeuble_id=immeubles.id");
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
