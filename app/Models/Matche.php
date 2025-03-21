<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    protected $fillable = [
        'tournament_id',
        'player_1_id',
        'player_2_id',
        'score_player_1',
        'score_player_2',
        'match_date',
    ];

    public function tournoi()
    {
        return $this->belongsTo(Tournoi::class);
    }

    public function player1()
    {
        return $this->belongsTo(User::class, 'player_1_id');
    }

    public function player2()
    {
        return $this->belongsTo(User::class, 'player_2_id');
    }
    
}
