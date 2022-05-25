<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;
    protected $fillable = ['avocat_id','promesse_vente_id',
        'signaturePromesseAcquereur','signaturePromesseDirecteurCommercial'
    ];
    /*************************************************/
        public function promessevente(){
            return $this->belongsTo(PromesseVente::class);
        }
    /*************************************************/
    public function avocat(){
        return $this->belongsTo(Avocat::class);
    }
}
