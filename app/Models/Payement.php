<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;
    protected $fillable = ['promesse_vente_id','prix_payer'];

    public function promessevente(){
        return $this->belongsTo(PromesseVente::class);
    }
    
}
