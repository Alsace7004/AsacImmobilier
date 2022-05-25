<?php

namespace App\Http\Controllers;

use App\Models\ProcesVerbal;
use Illuminate\Http\Request;

class ProcesVerbalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $procesVerbals = ProcesVerbal::all();
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
            'contrat_vente_definitif_id'=>'required|integer',
            'signature_acquereur'=>'required|string'
        ]);
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
