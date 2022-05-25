<?php

namespace App\Http\Controllers;

use App\Models\ContratVenteDefinitif;
use Illuminate\Http\Request;

class ContratVenteDefinitifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contratVenteDefinitifs = ContratVenteDefinitif::all();
        return $contratVenteDefinitifs;
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
            'avocat_id'=>'required|integer',
            'promesse_vente_id'=>'required|integer',
            'promesse_vente_client_id'=>'required|integer',
            'promesse_vente_appartement_id'=>'required|integer',
            'prix_vente'=>'required|numeric',
            'type_payement'=>'required|string',
            'description_appartement'=>'required|string',
            'signature_acquereur'=>'required|string',
            'signature_directeur_commercial'=>'required|string'
        ]);
        return ContratVenteDefinitif::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContratVenteDefinitif  $contratVenteDefinitif
     * @return \Illuminate\Http\Response
     */
    public function show(ContratVenteDefinitif $contratVenteDefinitif)
    {
        //
        return $contratVenteDefinitif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContratVenteDefinitif  $contratVenteDefinitif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratVenteDefinitif $contratVenteDefinitif)
    {
        //
        $data = $request->validate([
            'avocat_id'=>'required|integer',
            'promesse_vente_id'=>'required|integer',
            'promesse_vente_client_id'=>'required|integer',
            'promesse_vente_appartement_id'=>'required|integer',
            'prix_vente'=>'required|numeric',
            'type_payement'=>'required|string',
            'description_appartement'=>'required|string',
            'signature_acquereur'=>'required|string',
            'signature_directeur_commercial'=>'required|string'
        ]);
        $contratVenteDefinitif->update($data);
        return $contratVenteDefinitif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContratVenteDefinitif  $contratVenteDefinitif
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratVenteDefinitif $contratVenteDefinitif)
    {
        //
        return $contratVenteDefinitif->delete();
    }
}
