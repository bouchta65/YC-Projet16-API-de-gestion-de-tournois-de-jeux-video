<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matche;

class MatcheController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/matches",
     *     summary="Ajouter un nouveau match",
     *     tags={"Matches"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tournoi_id", "player_1_id", "player_2_id", "score_player_1", "score_player_2", "match_date"},
     *             @OA\Property(property="tournoi_id", type="integer", example=1),
     *             @OA\Property(property="player_1_id", type="integer", example=5),
     *             @OA\Property(property="player_2_id", type="integer", example=7),
     *             @OA\Property(property="score_player_1", type="integer", example=3),
     *             @OA\Property(property="score_player_2", type="integer", example=1),
     *             @OA\Property(property="match_date", type="string", format="date", example="2025-03-28")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Match ajouté avec succès"),
     *     @OA\Response(response=400, description="Erreur de validation"),
     *     @OA\Response(response=500, description="Erreur serveur")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/matches",
     *     summary="Récupérer la liste des matches",
     *     tags={"Matches"},
     *     @OA\Response(response=200, description="Liste des matches récupérée avec succès"),
     *     @OA\Response(response=500, description="Erreur serveur")
     * )
     */
    public function show()
    {
        try {
            $matches = Matche::get();
            return response()->json(['message' => 'Matches list retrieved successfully', 'matches' => $matches], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/matches/{id}",
     *     summary="Récupérer un match spécifique",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Match récupéré avec succès"),
     *     @OA\Response(response=404, description="Match non trouvé"),
     *     @OA\Response(response=500, description="Erreur serveur")
     * )
     */
    public function showDetails($id)
    {
        try {
            $matche = Matche::findOrFail($id);
            return response()->json(['message' => 'Match retrieved successfully', 'matche' => $matche], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/matches/{id}",
     *     summary="Mettre à jour un match",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="tournoi_id", type="integer", example=1),
     *             @OA\Property(property="player_1_id", type="integer", example=5),
     *             @OA\Property(property="player_2_id", type="integer", example=7),
     *             @OA\Property(property="score_player_1", type="integer", example=4),
     *             @OA\Property(property="score_player_2", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Match mis à jour avec succès"),
     *     @OA\Response(response=400, description="Erreur de validation"),
     *     @OA\Response(response=404, description="Match non trouvé"),
     *     @OA\Response(response=500, description="Erreur serveur")
     * )
     */
    public function updateMatche(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tournoi_id' => 'required|exists:tournois,id',
            'player_1_id' => 'exists:users,id',
            'player_2_id' => 'exists:users,id|different:player_1_id',
            'score_player_1' => 'integer|min:0',
            'score_player_2' => 'integer|min:0',
        ]);

        try {
            $matche = Matche::findOrFail($id);
            $matche->update($validatedData);
            return response()->json(['message' => 'Match updated successfully', 'matche' => $matche], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/matches/{id}",
     *     summary="Supprimer un match",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Match supprimé avec succès"),
     *     @OA\Response(response=404, description="Match non trouvé"),
     *     @OA\Response(response=500, description="Erreur serveur")
     * )
     */
    public function deleteMatche($id)
    {
        try {
            $matche = Matche::findOrFail($id);
            $matche->delete();
            return response()->json(["message" => "Match removed successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
}

