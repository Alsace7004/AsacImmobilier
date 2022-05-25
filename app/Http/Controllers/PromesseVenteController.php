<?php

namespace App\Http\Controllers;

use App\Models\PromesseVente;
use Illuminate\Http\Request;

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
        $promesseVentes = PromesseVente::all();
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
            'etat'=>'required|boolean',
            'nom_promesse'=>'required|string'
        ]);
        $data['prixVenteDefinitifTTC']=$data['prixVenteDefinitifHT']*(1+($data['tauxTVA'])/100);
        $avancePermis = (20* $data['prixVenteDefinitifTTC'])/100;
        if($data['avance']>$avancePermis){
            return PromesseVente::create($data);
        }else{
            return response()->json([
                'Error Message' => 'Cette avance doit être supérieure à 20% du prix de vente TTC',
                'Avance Permis' => $avancePermis
            ]);
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
            'etat'=>'required|boolean',
            'nom_promesse'=>'required|string'
        ]);
        $data['prixVenteDefinitifTTC']=$data['prixVenteDefinitifHT']*(1+($data['tauxTVA'])/100);
        $avancePermis = (20* $data['prixVenteDefinitifTTC'])/100;
        if($data['avance']>$avancePermis){
            return PromesseVente::create($data);
        }else{
            return response()->json([
                'Error Message' => 'Cette avance doit être supérieure à 20% du prix de vente TTC',
                'Avance Permis' => $avancePermis
            ]);
        }
        $promesseVente->update($data);
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
}
