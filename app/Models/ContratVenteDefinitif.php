<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratVenteDefinitif extends Model
{
    use HasFactory;

    protected $fillable= [
        'avocat_id',
        'promesse_vente_id',
        'promesse_vente_appartement_id',
        'promesse_vente_client_id',

        'description_appartement',
        'prix_vente',
        'type_payement',
        'signature_acquereur',
        'signature_directeur_commercial'
    ];

    public function avocat(){
        return $this->belongsTo(Avocat::class);
    }

    public function promessevente(){
        return $this->belongsTo(PromesseVente::class);
    }

    public function procesverbal(){
        return $this->hasOne(ProcesVerbal::class);
    }
}
