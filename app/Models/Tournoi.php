<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournoi extends Model
{
    protected $fillable = [
        'tournoi_id',
        'rules',
        'nb_players',
        'image',
    ];

    public function mathe(){
        return $this->hasMany(Matche::class);
    }

    public function User()
    {
        return $this->belongsToMany(User::class);
    }
}
