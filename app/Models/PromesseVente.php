<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromesseVente extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'appartement_id',
        'tauxTVA',
        'prixVenteDefinitifHT',
        'prixVenteDefinitifTTC',
        'avance',
        'etat',
        'nom_promesse',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    /*************************************************/
    public function appartement(){
        return $this->belongsTo(Appartement::class);
    }
    /*************************************************/
    public function payements(){
        return $this->hasMany(Payement::class);
    }
    /*************************************************/
    public function desistement(){
        return $this->hasOne(Desistement::class);
    }
    /*************************************************/
    /*************************************************/
    public function signature(){
        return $this->hasOne(Signature::class);
    }
    /*************************************************/
    public function contratventedefinitif(){
        return $this->hasOne(ContratVenteDefinitif::class);
    }
}
