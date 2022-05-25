<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;
    protected $fillable = [
        'immeuble_id',
        'numero_etage',
        'numero_appartement',
        'numero',
        'superficie',
        'nbr_chambre',
        'prix_previsionnel',
        'type'
    ];

    public function immeuble(){
        return $this->belongsTo(Immeuble::class);
    }
    public function visites(){
        return $this->hasMany(Visite::class);
    }
    /*************************************************/
    public function promessevente(){
        return $this->hasOne(PromesseVente::class);
    }
    /*************************************************/
}
