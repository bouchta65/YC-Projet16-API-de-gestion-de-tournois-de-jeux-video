<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TournoiPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournoi_id',
        'player_id',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournoi::class, 'tournament_id');
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
