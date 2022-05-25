<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    use HasFactory;
    protected $fillable = ['nom','adresse','nbr_appartement','nbr_etages'];

    public function appartements(){
        return $this->hasMany(Appartement::class);
    }
}
