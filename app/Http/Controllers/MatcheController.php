<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Matche;

class MatcheController extends Controller
{
    public function AddMatche(Request $request)
    {
        $validatedData = $request->validate([
            'tournoi_id' => 'required|exists:tournois,id',
            'player_1_id' => 'required|exists:users,id',
            'player_2_id' => 'required|exists:users,id|different:player_1_id',
            'score_player_1' => 'required|integer|min:0',
            'score_player_2' => 'required|integer|min:0',
            'match_date' => 'required|date'
        ]);
    
        try {
            $match = Matche::create($validatedData);
    
            return response()->json(["message" => "Match ajouté avec succès", "match" => $match], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Erreur lors de l'ajout du match", "error" => $e->getMessage()], 500);
        }
    }

    public function show(){
        try{
            
            $matches = Matche::get();

            return response()->json(['message' => 'Matches list retrieved successfully', 'matches' => $matches], 200);

            
        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    public function showDetails($id){
        try{
            $macthe = Matche::findorfail($id);
            
            return response()->json(['message' => 'macthe retrieved successfully', 'macthe' => $macthe], 200);

            
        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    public function updateMatche(Request $request,$id){
        $validatedData = $request->validate([
            'tournoi_id' => 'required|exists:tournois,id',
            'player_1_id' => 'exists:users,id',
            'player_2_id' => 'exists:users,id|different:player_1_id',
            'score_player_1' => 'integer|min:0',
            'score_player_2' => 'integer|min:0',
        ]);
        try{
            $matche = Matche::findOrFail($id);
            $matche->update($validatedData);
            return response()->json(['message'=> 'matche updated successfully','matche'=>$matche],200);
        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }    
    }

    public function deleteMatche($id){
        try {
            $matche = matche::findOrFail($id);
            $matche->delete();
    
            return response()->json(["message" => "Matche removed successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
    
}
