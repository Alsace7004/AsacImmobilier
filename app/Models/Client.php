<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'CIN',
        'nom',
        'prenom1',
        'prenom2',
        'adresse',
        'telephone',
        'profession'
    ];

    public function visites(){
        return $this->hasMany(Visite::class);
    }

    public function promesseventes(){
        return $this->hasMany(PromesseVente::class);
    }
}
