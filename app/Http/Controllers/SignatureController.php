<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$signatures = Signature::all();
        $signatures = DB::SELECT("SELECT 
        signatures.id,avocats.nom,avocats.prenom,
        signatures.signaturePromesseAcquereur,signatures.signaturePromesseDirecteurCommercial,
        signatures.created_at,
        CONCAT(clients.nom,' ',clients.prenom1,'/',appartements.numero,'/',immeubles.nom) as client_appartement_immeuble 
        FROM signatures,avocats,`promesse_ventes`,clients,appartements,immeubles 
        WHERE signatures.avocat_id = avocats.id AND
        signatures.promesse_vente_id= promesse_ventes.id AND
        promesse_ventes.client_id = clients.id and 
        promesse_ventes.appartement_id=appartements.id and 
        appartements.immeuble_id=immeubles.id");
        return $signatures;
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
            'signaturePromesseAcquereur'=>'required|string',
            'signaturePromesseDirecteurCommercial'=>'required|string'
        ]);
        $data['signaturePromesseAcquereur'] = time().'@'.uniqid();
        $data['signaturePromesseDirecteurCommercial'] = time().'@'.uniqid();
        return Signature::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function show(Signature $signature)
    {
        //
        return $signature;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signature $signature)
    {
        //
        $data = $request->validate([
            'avocat_id'=>'required|integer',
            'promesse_vente_id'=>'required|integer',
            'signaturePromesseAcquereur'=>'required|string',
            'signaturePromesseDirecteurCommercial'=>'required|string'
        ]);
        $data['signaturePromesseAcquereur'] = time().'@'.uniqid();
        $data['signaturePromesseDirecteurCommercial'] = time().'@'.uniqid();
        $signature->update($data);
        return $signature;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signature $signature)
    {
        //
        return $signature->delete();
    }
}
