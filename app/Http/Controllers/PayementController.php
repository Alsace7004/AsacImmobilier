<?php

namespace App\Http\Controllers;

use App\Models\Payement;
use Illuminate\Http\Request;

class PayementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payements = Payement::all();
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
        return Payement::create($data);
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
