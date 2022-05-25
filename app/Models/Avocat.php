<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avocat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'telephone1',
        'telephone2',
        'telephone3',
        'num_autorisation'
    ];

    public function signature(){
        return $this->hasOne(Signature::class);
    }

    public function contratventedefinitifs(){
        return $this->hasOne(ContratVenteDefinitif::class);
    }

    
}
