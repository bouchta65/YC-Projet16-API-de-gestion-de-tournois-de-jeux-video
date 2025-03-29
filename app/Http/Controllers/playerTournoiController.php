<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TournoiPlayer;
use App\Models\Tournoi;
use App\Models\User;

class playerTournoiController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/tournoi/{idTournoi}/add-player",
     *     summary="Add a player to a tournament",
     *     tags={"Tournament"},
     *     @OA\Parameter(
     *         name="idTournoi",
     *         in="path",
     *         required=true,
     *         description="ID of the tournament",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Player added successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error occurred"
     *     )
     * )
     */
    public function addPlayer($idTournoi){
        try{
            $player = TournoiPlayer::create([
                'tournoi_id'=> $idTournoi,
                'player_id'=> auth()->user()->id
            ]);
            return response()->json(['message'=> 'Player added successfully','player-Tournoi'=>$player], 200);

        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tournoi/{id}/players",
     *     summary="Retrieve all players of a tournament",
     *     tags={"Tournament"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the tournament",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of players retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error occurred"
     *     )
     * )
     */
    public function showPlayersTournoi($id){
        try{
            $tournoi = Tournoi::findOrFail($id);
            
            $playersTournoi = TournoiPlayer::where('tournoi_id', $tournoi->id)->get();

            return response()->json(['message' => 'Player list retrieved successfully', 'players' => $playersTournoi], 200);

        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/tournoi/{idTournoi}/remove-player",
     *     summary="Remove a player from a tournament",
     *     tags={"Tournament"},
     *     @OA\Parameter(
     *         name="idTournoi",
     *         in="path",
     *         required=true,
     *         description="ID of the tournament",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Player removed successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error occurred"
     *     )
     * )
     */
    public function deletePlayersTournoi($idTournoi)
    {
        try {
            TournoiPlayer::where('tournoi_id', $idTournoi)
                ->where('player_id', auth()->user()->id)
                ->delete();
    
            return response()->json(["message" => "Player removed from tournament"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
}
