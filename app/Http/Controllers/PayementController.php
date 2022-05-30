<?php

namespace App\Http\Controllers;

use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayementController extends Controller
{
    public function payementCount(){
        $nbr_payements = DB::SELECT('SELECT COUNT(*) as nbr_total_payement FROM payements');
        return $nbr_payements;
    }
    public function clientImmeubleAppartement(){
        $payements = DB::SELECT("SELECT promesse_ventes.id, CONCAT(clients.nom,' ',clients.prenom1,'/',appartements.numero,'/',immeubles.nom) as client_appartement_immeuble FROM `promesse_ventes`,clients,appartements,immeubles WHERE promesse_ventes.client_id = clients.id and promesse_ventes.appartement_id=appartements.id and appartements.immeuble_id=immeubles.id");
        return $payements;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payements = DB::SELECT("SELECT payements.id,payements.prix_payer,payements.created_at, CONCAT(clients.nom,'',clients.prenom1,'/',appartements.numero,' / ',immeubles.nom) as appartement_immeuble FROM payements,`promesse_ventes`,clients,appartements,immeubles WHERE payements.promesse_vente_id=promesse_ventes.id and promesse_ventes.client_id = clients.id and promesse_ventes.appartement_id=appartements.id and appartements.immeuble_id=immeubles.id");
        return $payements;
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
            'promesse_vente_id'=>'required|integer',
            'prix_payer'=>'required|numeric'
        ]);
        $pvi = $data['promesse_vente_id'];
        $pp = $data['prix_payer'];
        $ttc = DB::SELECT("SELECT prixVenteDefinitifTTC FROM promesse_ventes WHERE id = $pvi");
        /*return response()->json([
            '$ttc' => $ttc[0]->prixVenteDefinitifTTC
        ],400);*/
        $av = DB::SELECT("SELECT avance FROM promesse_ventes WHERE id = $pvi");
        /*return response()->json([
            '$av' => $av[0]->avance
        ],400);*/
        $pr = ($ttc[0]->prixVenteDefinitifTTC)-($av[0]->avance);
        
        if($ttc>($av[0]->avance)){
            if($pp>$pr){
                $ristourne =  $pp-$pr;
                DB::SELECT("UPDATE promesse_ventes SET avance = avance + $pp WHERE id = $pvi");
                Payement::create($data);
                return response()->json([
                    'message'=>'Vous avez une ristourne de ('.$ristourne.'XOF)'
                ],200);
            }else if($pp<$pr){
                $ristourne =  $pr-$pp;
                DB::SELECT("UPDATE promesse_ventes SET avance = avance + $pp WHERE id = $pvi");
                Payement::create($data);
                return response()->json([
                    'message'=>'Il vous reste ('.$ristourne.' XOF à payer)'
                ],200);
            }else if($pp == $pr){
                DB::SELECT("UPDATE promesse_ventes SET avance = avance + $pp WHERE id = $pvi");
                Payement::create($data);
                return response()->json([
                    'message'=>'Vous avez tous solder'
                ],200);
            }
        }else if($ttc==($av[0]->avance)){
            return response()->json([
                'message'=>"C'est bon, vous avez solder"
            ],200);
        }else{
            return response()->json([
                'message'=>"Une erreure malencontreuse est survenu !!!"
            ],400);
        }
       
        //|| $ttc>$pp
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function show(Payement $payement)
    {
        //
        return $payement;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payement $payement)
    {
        //
        $data = $request->validate([
            'promesse_vente_id'=>'required|integer',
            'prix_payer'=>'required|numeric'
        ]);
        $payement->update($data);
        return $payement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payement $payement)
    {
        //
        return $payement->delete();
    }
}
