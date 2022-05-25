<?php

namespace App\Http\Controllers;

use App\Models\Desistement;
use Illuminate\Http\Request;

class DesistementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $desistements = Desistement::all();
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
            'promesse_vente_id'=>'required|integer',
            'causes_annulation'=>'required|string'
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
            'causes_annulation'=>'required|string'
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
