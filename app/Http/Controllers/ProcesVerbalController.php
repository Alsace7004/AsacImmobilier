<?php

namespace App\Http\Controllers;

use App\Models\ProcesVerbal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcesVerbalController extends Controller
{
    public function procesverbalCount(){
        $nbr_procesverbals = DB::SELECT('SELECT COUNT(*) as nbr_total_procesverbal FROM proces_verbals');
        return $nbr_procesverbals;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$procesVerbals = ProcesVerbal::all();
        $procesVerbals = DB::SELECT("SELECT 
        proces_verbals.id,
        proces_verbals.signature_acquereur,users.name,proces_verbals.created_at,
        CONCAT(clients.nom,' ',clients.prenom1,'/',appartements.numero,'/',immeubles.nom) as client_appartement_immeuble 
        FROM proces_verbals,
        contrat_vente_definitifs,users,`promesse_ventes`,clients,appartements,immeubles 
        WHERE
        proces_verbals.contrat_vente_definitif_id = contrat_vente_definitifs.id AND
        proces_verbals.user_id = users.id AND
        contrat_vente_definitifs.promesse_vente_id= promesse_ventes.id AND
        promesse_ventes.client_id = clients.id and 
        promesse_ventes.appartement_id=appartements.id and 
        appartements.immeuble_id=immeubles.id");
        return $procesVerbals;
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
            'user_id'=>'required|integer',
            'contrat_vente_definitif_id'=>'required|integer|unique:proces_verbals,contrat_vente_definitif_id',
            'signature_acquereur'=>'required|string'
        ]);
        $data['user_id'] = 2;
        $data['signature_acquereur'] = '@cqu'.uniqid();
        return ProcesVerbal::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProcesVerbal  $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function show(ProcesVerbal $procesVerbal)
    {
        //
        return $procesVerbal;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProcesVerbal  $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcesVerbal $procesVerbal)
    {
        //
        $data = $request->validate([
            'user_id'=>'required|integer',
            'contrat_vente_definitif_id'=>'required|integer',
            'signature_acquereur'=>'required|string'
        ]);
        $data['user_id'] = 3;
        $data['signature_acquereur'] = '@cqu'.uniqid();
        $procesVerbal->update($data);
        return $procesVerbal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcesVerbal  $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcesVerbal $procesVerbal)
    {
        //
        return $procesVerbal->delete();
    }
}
