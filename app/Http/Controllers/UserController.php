<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Retrieve all users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="List of users"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error"
     *     )
     * )
     */
    public function Show(){
        try {
            $users = User::all();
            if ($users) {
                return response()->json(['message' => "All users retrieved successfully", 'Users' => $users], 200);
            } else {
                return response()->json(['message' => "Aucun user disponible", 'Users' => $users], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/me",
     *     summary="Retrieve the authenticated user's information",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user details",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="User not authenticated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error"
     *     )
     * )
     */
    public function showOne(){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json(["message" => "User not authenticated."], 401);
            }

            return response()->json(["user" => $user], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
}
