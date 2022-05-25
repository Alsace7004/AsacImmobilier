<?php

namespace App\Http\Controllers;

use App\Models\Avocat;
use Illuminate\Http\Request;

class AvocatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $avocats = Avocat::all();
        return $avocats;
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
            'prenom'=>'required|string',
            'adresse'=>'required|string',
            'telephone1'=>'required|string',
            'telephone2'=>'string',
            'telephone3'=>'string',
            'num_autorisation'=>'string|required',
        ]);
        return Avocat::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avocat  $avocat
     * @return \Illuminate\Http\Response
     */
    public function show(Avocat $avocat)
    {
        //
        return $avocat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Avocat  $avocat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Avocat $avocat)
    {
        //
        $data = $request->validate([
            'nom'=>'required|string',
            'prenom'=>'required|string',
            'adresse'=>'required|string',
            'telephone1'=>'required|string',
            'telephone2'=>'string',
            'telephone3'=>'string',
            'num_autorisation'=>'string|required',
        ]);
        $avocat->update($data);
        return $avocat;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avocat  $avocat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avocat $avocat)
    {
        //
        return $avocat->delete();
    }
}
