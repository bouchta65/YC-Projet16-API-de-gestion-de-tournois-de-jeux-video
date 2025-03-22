<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;

class UserController extends Controller
{
    public function Show(){
        try{
            $users = User::All();
            if($users){
                return response()->json(['message'=>"All users retrieved successfully",'Users'=>$users],200);
            }else{
                return response()->json(['message'=>"Aucun user disponible",'Users'=>$users],200);

            }
        }catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
       
    }

    public function showOne(){
        try{
            $user = auth()->user();
            if(!$user){
                return response()->json(["message" => "User not authenticated."], 401);
            }

            return response()->json(["user" => $user], 200);
            
        }catch (\Exception $e) {
            return response()->json(["message" => "Error", "error" => $e->getMessage()], 500);
        }
    }
}
