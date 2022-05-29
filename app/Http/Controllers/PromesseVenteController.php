<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromesseVente;
use Illuminate\Support\Facades\DB;

class PromesseVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$promesseVentes = PromesseVente::all();
        $promesseVentes = DB::SELECT("SELECT
        promesse_ventes.id, 
        promesse_ventes.tauxTVA,
        promesse_ventes.prixVenteDefinitifHT,
        promesse_ventes.prixVenteDefinitifTTC,
        promesse_ventes.avance,
        promesse_ventes.etat,
        promesse_ventes.created_at,
        clients.nom,clients.prenom1,
        CONCAT(appartements.numero,' / ',immeubles.nom) as appartement_immeuble
        FROM `promesse_ventes`,clients,appartements,immeubles
        WHERE 
        promesse_ventes.client_id = clients.id and 
        promesse_ventes.appartement_id=appartements.id and 
        appartements.immeuble_id=immeubles.id");
        return $promesseVentes;
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
            'client_id'=>'required|integer',
            'appartement_id'=>'required|integer',
            'tauxTVA'=>'required|numeric',
            'prixVenteDefinitifHT'=>'required|numeric',
            'prixVenteDefinitifTTC'=>'required|numeric',
            'avance'=>'required|numeric',
            'etat'=>'required|string'
            //'nom_promesse'=>'required|string'
        ]);
        $data['etat']=true;
        $data['nom_promesse']="holla";
        $data['prixVenteDefinitifTTC']=$data['prixVenteDefinitifHT']*(1+($data['tauxTVA'])/100);
        $avancePermis = (20* $data['prixVenteDefinitifTTC'])/100;
        if($data['avance']>$avancePermis){
            return PromesseVente::create($data);
        }else{
            return response()->json([
                'Message' => 'Cette avance doit être supérieure à 20% du prix de vente TTC('.$data['prixVenteDefinitifTTC'].' XOF)',
                'AvancePermis' => $avancePermis,
                
            ],400);
        }
  

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PromesseVente  $promesseVente
     * @return \Illuminate\Http\Response
     */
    public function show(PromesseVente $promesseVente)
    {
        //
        return $promesseVente;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PromesseVente  $promesseVente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromesseVente $promesseVente)
    {
        //
        $data = $request->validate([
            'client_id'=>'required|integer',
            'appartement_id'=>'required|integer',
            'tauxTVA'=>'required|numeric',
            'prixVenteDefinitifHT'=>'required|numeric',
            'prixVenteDefinitifTTC'=>'required|numeric',
            'avance'=>'required|numeric',
            'etat'=>'required|string',
            //'nom_promesse'=>'required|string'
        ]);
        $data['nom_promesse']="holla";
        $data['prixVenteDefinitifTTC']=$data['prixVenteDefinitifHT']*(1+($data['tauxTVA'])/100);
        $avancePermis = (20* $data['prixVenteDefinitifTTC'])/100;
        if($data['avance']>$avancePermis){
            $promesseVente->update($data);
        }else{
            return response()->json([
                'Message' => 'Cette avance doit être supérieure à 20% du prix de vente TTC('.$data['prixVenteDefinitifTTC'].' XOF)',
                'AvancePermis' => $avancePermis,
                
            ],400);
        }
        
        return $promesseVente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PromesseVente  $promesseVente
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromesseVente $promesseVente)
    {
        //
        return $promesseVente->delete();
    }

    public function promesseVentePayement(Request $request,$id){
        $data = $request->validate([
            'avance'=>'required|numeric'
        ]);

        return response()->json([
            '$id' => $id,
            '$avance'=>$data['avance']
        ],400);
    }
}
