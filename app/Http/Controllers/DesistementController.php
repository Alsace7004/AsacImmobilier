<?php

namespace App\Http\Controllers;

use App\Models\Desistement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesistementController extends Controller
{
    public function desistementCount(){
        $nbr_desistements = DB::SELECT('SELECT COUNT(*) as nbr_total_desistement FROM desistements');
        return $nbr_desistements;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$desistements = Desistement::all();
        $desistements = DB::SELECT("SELECT 
        desistements.id,
        desistements.numero,
        desistements.causes_annulation,
        desistements.created_at,
        CONCAT(clients.nom,' ',clients.prenom1,'/',appartements.numero,'/',immeubles.nom) as client_appartement_immeuble 
        FROM desistements,`promesse_ventes`,clients,appartements,immeubles 
        WHERE 
            desistements.promesse_vente_id = promesse_ventes.id AND
            promesse_ventes.client_id = clients.id and 
            promesse_ventes.appartement_id=appartements.id and 
            appartements.immeuble_id=immeubles.id");
        return $desistements;
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
            'promesse_vente_id'=>'required|integer|unique:desistements,promesse_vente_id',
            'causes_annulation'=>'required|string',
            'numero'=>'required|string'
        ]);
        $data['numero']= time().'+'.$data['promesse_vente_id'];
        return Desistement::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Desistement  $desistement
     * @return \Illuminate\Http\Response
     */
    public function show(Desistement $desistement)
    {
        //
        return $desistement;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Desistement  $desistement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Desistement $desistement)
    {
        //
        $data = $request->validate([
            'promesse_vente_id'=>'required|integer',
            'causes_annulation'=>'required|string',
            'numero'=>'required|string'
        ]);
        $data['numero']= time().'+'.$data['promesse_vente_id'];
        $desistement->update($data);
        return $desistement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Desistement  $desistement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desistement $desistement)
    {
        //
        return $desistement->delete();
    }
}
