<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ContratVenteDefinitif;

class ContratVenteDefinitifController extends Controller
{
    public function contratVenteDefinitifCount(){
        $nbr_contratVenteDefinitifs = DB::SELECT('SELECT COUNT(*) as nbr_total_contratVenteDefinitif FROM contrat_vente_definitifs');
        return $nbr_contratVenteDefinitifs;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$contratVenteDefinitifs = ContratVenteDefinitif::all();
        $contratVenteDefinitifs = DB::SELECT("SELECT 
        contrat_vente_definitifs.id,contrat_vente_definitifs.prix_vente,
        contrat_vente_definitifs.type_payement,contrat_vente_definitifs.signature_acquereur,
        contrat_vente_definitifs.signature_directeur_commercial,contrat_vente_definitifs.description_appartement,
        contrat_vente_definitifs.created_at,avocats.nom,avocats.prenom,
        CONCAT(clients.nom,' ',clients.prenom1,'/',appartements.numero,'/',immeubles.nom) as client_appartement_immeuble 
        FROM contrat_vente_definitifs,avocats,`promesse_ventes`,clients,appartements,immeubles 
        WHERE contrat_vente_definitifs.avocat_id = avocats.id AND
                contrat_vente_definitifs.promesse_vente_id= promesse_ventes.id AND
                promesse_ventes.client_id = clients.id and 
                promesse_ventes.appartement_id=appartements.id and 
                appartements.immeuble_id=immeubles.id");
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
            //'promesse_vente_client_id'=>'required|integer',
            //'promesse_vente_appartement_id'=>'required|integer',
            'prix_vente'=>'required|numeric',
            'type_payement'=>'required|string',
            'description_appartement'=>'required|string',
            'signature_acquereur'=>'required|string',
            'signature_directeur_commercial'=>'required|string'
        ]);
        $data['signature_acquereur'] = '@'.uniqid();
        $data['signature_directeur_commercial'] = '@'.uniqid();
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
            //'promesse_vente_client_id'=>'required|integer',
            //'promesse_vente_appartement_id'=>'required|integer',
            'prix_vente'=>'required|numeric',
            'type_payement'=>'required|string',
            'description_appartement'=>'required|string',
            'signature_acquereur'=>'required|string',
            'signature_directeur_commercial'=>'required|string'
        ]);
        $data['signature_acquereur'] = '@'.uniqid();
        $data['signature_directeur_commercial'] = '@'.uniqid();
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
