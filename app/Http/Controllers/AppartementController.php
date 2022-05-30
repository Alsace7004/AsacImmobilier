<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppartementController extends Controller
{
    public function appartementCount(){
        $nbr_appartements = DB::SELECT('SELECT COUNT(*) as nbr_total_appartement FROM appartements');
        return $nbr_appartements;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$appartements = Appartement::all();
        $appartements = DB::SELECT("SELECT 
        appartements.*,CONCAT(appartements.numero,' / ',immeubles.nom) as appartement_immeuble FROM appartements,immeubles 
        WHERE appartements.immeuble_id=immeubles.id");
        return $appartements;
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
            'numero_etage'=>'required|integer',
            'numero_appartement'=>'required|integer',
            'numero'=>'string',
            'superficie'=>'required|numeric',
            'nbr_chambre'=>'required|integer',
            'prix_previsionnel'=>'required|numeric',
            'type'=>'required|string',
            'immeuble_id'=>'required|integer'
        ]);
        $data = $request->all();
        $data['numero'] = $data['numero_etage'].'-'.$data['numero_appartement'];
        $data['type'] =1;
        return Appartement::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function show(Appartement $appartement)
    {
        //
        return $appartement;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appartement $appartement)
    {
        //
        $data = $request->validate([
            'numero_etage'=>'required|integer',
            'numero_appartement'=>'required|integer',
            'numero'=>'string',
            'superficie'=>'required|numeric',
            'nbr_chambre'=>'required|integer',
            'prix_previsionnel'=>'required|numeric',
            'type'=>'required|string',
            'immeuble_id'=>'required|integer'
        ]);
        $data = $request->all();
        $data['numero'] = $data['numero_etage'].'-'.$data['numero_appartement'];
        //$data['type'] =1;
        $appartement->update($data);
        return $appartement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appartement  $appartement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appartement $appartement)
    {
        //
        return $appartement->delete();
    }
}
