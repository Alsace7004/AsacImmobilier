<?php

namespace App\Http\Controllers;

use App\Models\Payement;
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
        /*return response()->json([
            '$id' => $id,
            'message'=>$data['avance']
        ],400);*/
       // $pvi = $data['promesse_vente_id'];
        $pp = $data['avance'];
        $data['promesse_vente_id']=$id;
        $data['prix_payer']=$data['avance'];
        $ttc = DB::SELECT("SELECT prixVenteDefinitifTTC FROM promesse_ventes WHERE id = $id");
        $av = DB::SELECT("SELECT avance FROM promesse_ventes WHERE id = $id");
        $pr = ($ttc[0]->prixVenteDefinitifTTC)-($av[0]->avance);//prix_restant_a_payer
        
        if($ttc>($av[0]->avance)){
            if($pp>$pr){
                $ristourne =  $pp-$pr;
                DB::SELECT("UPDATE promesse_ventes SET avance = avance + $pp WHERE id = $id");
                Payement::create($data);
                return response()->json([
                    'ristourne'=>$ristourne,
                    'message'=>'Vous avez soldé et vous avez une ristourne de ('.$ristourne.' XOF)'
                ],400);
            }else if($pp<$pr){
                $ristourne =  $pr-$pp;
                DB::SELECT("UPDATE promesse_ventes SET avance = avance + $pp WHERE id = $id");
                Payement::create($data);
                return response()->json([
                    'ristourne'=>$ristourne,
                    'message'=>'Il vous reste encore ('.$ristourne.' XOF à payer)'
                ],400);
            }else if($pp == $pr){
                DB::SELECT("UPDATE promesse_ventes SET avance = avance + $pp WHERE id = $id");
                Payement::create($data);
                return response()->json([
                    'ristourne'=>$ristourne=0,
                    'message'=>'Vous avez tous solder merci!!!'
                ],400);
            }
        }else if($ttc==($av[0]->avance)){
            return response()->json([
                'ristourne'=>$ristourne=0,
                'message'=>"C'est bon, vous avez solder"
            ],400);
        }else{
            return response()->json([
                'ristourne'=>$ristourne=0,
                'message'=>"Une erreure malencontreuse est survenu !!!"
            ],400);
        }
    }
}
