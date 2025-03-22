<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TournoiPlayer;
use App\Models\Tournoi;
use App\Models\User;

class playerTournoiController extends Controller
{
    public function addPlayer($idTournoi ){
        try{
            $player = TournoiPlayer::create([
                'tournoi_id'=> $idTournoi,
                'player_id'=> auth()->user()->id
            ]);
            return response()->json(['message'=> 'player added successfully','player-Tournoi'=>$player],200);

        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    public function showPlayersTournoi($id){
        try{
            $tournoi = Tournoi::findorfail($id);
            
            $playersTournoi = TournoiPlayer::where('tournoi_id', $tournoi->id)->get();

            return response()->json(['message' => 'Player list retrieved successfully', 'players' => $playersTournoi], 200);

            
        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
}
