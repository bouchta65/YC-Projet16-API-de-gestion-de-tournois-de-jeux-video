<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournoi;
use App\Models\User;

class TournoiController extends Controller
{
    public function AddTournoi(Request $request){
        $validatorData = $request->validate([
            'name' => 'required|string|max:255',
            'rules' => 'required|string|max:255', 
            'nb_players' => 'required|integer|min:1', 
            'image' => 'nullable|image|max:2048', 
        ]);
        $validatorData['creator_id'] = auth()->user()->id;

        try{
            $tournoi = Tournoi::create($validatorData);
            return response()->json(['message'=>"Tournoi Added successfully",'tournoi'=>$tournoi],201); 

        }catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }


    public function Show(){
        try{
            $tournois = Tournoi::All();
            if($tournois){
                return response()->json(['message'=>"All Tournois retrieved successfully",'Tournois'=>$tournois],200);
            }else{
                return response()->json(['message'=>"Aucun tournoi disponible",'tournois'=>$tournois],200);

            }
        }catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
       
    }

    public function ShowById($id){
        try{
            $tournoi = Tournoi::findorfail($id);
            return response()->json(['message'=>"Tournoi retrieved successfully",'tournoi'=>$tournoi],200);

        }catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }

    }

    public function update(request $request, $id){
        $validatorData = $request->validate([
            'rules' => 'string|max:255', 
            'nb_players' => 'integer|min:1', 
            'image' => 'nullable|image|max:2048', 
            'name' => 'nullable|string|max:255',
        ]);

        

        try{
            $tournoi = Tournoi::findOrFail($id);
            if ($tournoi->creator_id != auth()->user()->id) {
                return response()->json(['message' => 'Unauthorized', 'error' => 'You are not the creator of this tournoi'], 403);
            }
            $tournoi->update($validatorData);
            return response()->json(['message'=> 'Tournoi updated successfully','tournoi'=>$tournoi],200);
        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }


    }

    public function delete($id){
        try{
            $tournoi = tournoi::findOrFail($id);
            if ($tournoi->creator_id != auth()->user()->id) {
                return response()->json(['message' => 'Unauthorized', 'error' => 'You are not the creator of this tournoi'], 403);
            }
            $tournoi->delete();
            return response()->json(['message'=>'tournoi deleted successfully'],200);
        }catch(\Exception $e){
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

  
}
