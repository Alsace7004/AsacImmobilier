<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImmeubleController extends Controller
{
    public function immeubleCount(){
        $nbr_immeubles = DB::SELECT('SELECT COUNT(*) as nbr_total_immeuble FROM immeubles');
        return $nbr_immeubles;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $immeubles = Immeuble::all();
        return $immeubles;
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
            'nom'=>'required|string',
            'adresse'=>'required|string',
            'nbr_appartement'=>'required|integer',
            'nbr_etages'=>'required|integer'
        ]);
        return Immeuble::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function show(Immeuble $immeuble)
    {
        //
        return $immeuble;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Immeuble $immeuble)
    {
        //
        $data = $request->validate([
            'nom'=>'required|string',
            'adresse'=>'required|string',
            'nbr_appartement'=>'required|integer',
            'nbr_etages'=>'required|integer'
        ]);
        $immeuble->update($data);
        return $immeuble;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Immeuble  $immeuble
     * @return \Illuminate\Http\Response
     */
    public function destroy(Immeuble $immeuble)
    {
        //
        return $immeuble->delete();
    }
}
