<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desistement extends Model
{
    use HasFactory;
    protected $fillable=[
        'promesse_vente_id',
        'numero',
        'causes_annulation'
    ];

    /*************************************************/
    public function promessevente(){
        return $this->belongsTo(PromesseVente::class);
    }
    /*************************************************/
}
