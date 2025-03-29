<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournoi;
use App\Models\User;

class TournoiController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/tournois",
     *     summary="Add a new tournament",
     *     tags={"Tournois"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","rules","nb_players"},
     *             @OA\Property(property="name", type="string", example="Championnat FIFA"),
     *             @OA\Property(property="rules", type="string", example="Standard rules"),
     *             @OA\Property(property="nb_players", type="integer", example=16),
     *             @OA\Property(property="image", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tournament added successfully"
     *     ),
     *     @OA\Response(response=500, description="Error")
     * )
     */
    public function AddTournoi(Request $request){
        $validatorData = $request->validate([
            'name' => 'required|string|max:255',
            'rules' => 'required|string|max:255', 
            'nb_players' => 'required|integer|min:1', 
            'image' => 'nullable|image|max:2048', 
        ]);
        $validatorData['creator_id'] = auth()->user()->id;

        try {
            $tournoi = Tournoi::create($validatorData);
            return response()->json(['message'=>"Tournoi Added successfully",'tournoi'=>$tournoi],201); 
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tournois",
     *     summary="Retrieve all tournaments",
     *     tags={"Tournois"},
     *     @OA\Response(
     *         response=200,
     *         description="List of tournaments"
     *     ),
     *     @OA\Response(response=500, description="Error")
     * )
     */
    public function Show(){
        try {
            $tournois = Tournoi::all();
            return response()->json(['message'=>"All Tournois retrieved successfully",'Tournois'=>$tournois],200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tournois/{id}",
     *     summary="Retrieve a tournament by ID",
     *     tags={"Tournois"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Tournament retrieved successfully"),
     *     @OA\Response(response=404, description="Tournament not found"),
     *     @OA\Response(response=500, description="Error")
     * )
     */
    public function ShowById($id){
        try {
            $tournoi = Tournoi::findOrFail($id);
            return response()->json(['message'=>"Tournoi retrieved successfully",'tournoi'=>$tournoi],200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/tournois/{id}",
     *     summary="Update a tournament",
     *     tags={"Tournois"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", nullable=true),
     *             @OA\Property(property="rules", type="string", nullable=true),
     *             @OA\Property(property="nb_players", type="integer", nullable=true),
     *             @OA\Property(property="image", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Tournament updated successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=500, description="Error")
     * )
     */
    public function update(Request $request, $id){
        $validatorData = $request->validate([
            'rules' => 'string|max:255', 
            'nb_players' => 'integer|min:1', 
            'image' => 'nullable|image|max:2048', 
            'name' => 'nullable|string|max:255',
        ]);

        try {
            $tournoi = Tournoi::findOrFail($id);
            if ($tournoi->creator_id != auth()->user()->id) {
                return response()->json(['message' => 'Unauthorized', 'error' => 'You are not the creator of this tournoi'], 403);
            }
            $tournoi->update($validatorData);
            return response()->json(['message'=> 'Tournoi updated successfully','tournoi'=>$tournoi],200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/tournois/{id}",
     *     summary="Delete a tournament",
     *     tags={"Tournois"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Tournament deleted successfully"),
     *     @OA\Response(response=403, description="Unauthorized"),
     *     @OA\Response(response=500, description="Error")
     * )
     */
    public function delete($id){
        try {
            $tournoi = Tournoi::findOrFail($id);
            if ($tournoi->creator_id != auth()->user()->id) {
                return response()->json(['message' => 'Unauthorized', 'error' => 'You are not the creator of this tournoi'], 403);
            }
            $tournoi->delete();
            return response()->json(['message'=>'Tournoi deleted successfully'],200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
}

