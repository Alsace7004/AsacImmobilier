<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

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
        $signatures = Signature::all();
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
