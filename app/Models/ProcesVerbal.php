<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesVerbal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contrat_vente_definitif_id',
        'signature_acquereur'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function contratventedefinitif(){
        return $this->belongsTo(ContratVenteDefinitif::class);
    }
}
