<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournoi extends Model
{
    use HasFactory;
    protected $fillable = [
        'tournoi_id',
        'name',
        'rules',
        'nb_players',
        'image',
        'creator_id'
    ];

    public function mathe(){
        return $this->hasMany(Matche::class);
    }

    public function User()
    {
        return $this->belongsToMany(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
