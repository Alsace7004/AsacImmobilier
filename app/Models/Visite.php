<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id','appartement_id','remarque_client'
    ];

    public function appartement(){
        return $this->belongsTo(Appartement::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
}
