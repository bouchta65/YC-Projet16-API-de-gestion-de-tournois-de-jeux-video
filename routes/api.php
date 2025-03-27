<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TournoiController;
use App\Http\Controllers\playerTournoiController;
use App\Http\Controllers\MatcheController;



Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::middleware('jwt')->group(function () {
    Route::post('/logout', [AuthController::class,"logout"]);
    Route::put('/user', [AuthController::class, 'updateUser']);
    Route::get("/user",[UserController::class,'showOne']);
    Route::post("/tournaments",[TournoiController::class,'AddTournoi']);
    Route::get("/tournaments",[TournoiController::class,'Show']);
    Route::get("/tournaments/{id}",[TournoiController::class,'ShowById']);
    Route::put("/tournaments/{id}",[TournoiController::class,'update']);
    Route::delete("/tournaments/{id}",[TournoiController::class,'delete']);
    Route::post("/tournaments/{id}/players",[playerTournoiController::class,'addPlayer']);
    Route::get("/tournaments/{id}/players",[playerTournoiController::class,'showPlayersTournoi']);
    Route::delete("/tournaments/{id}/players",[playerTournoiController::class,'deletePlayersTournoi']);
    Route::post("/matches",[MatcheController::class,'AddMatche']);
    Route::get("/matches",[MatcheController::class,'show']);
    Route::post("/matches/{id}",[MatcheController::class,'showDetails']);
    Route::put("/matches/{id}",[MatcheController::class,'updateMatche']);
    Route::delete("/matches/{id}",[MatcheController::class,'deleteMatche']);
});




Route::middleware(['jwt', 'admin'])->group(function () {
    Route::get("/users",[UserController::class,'Show']);
});
