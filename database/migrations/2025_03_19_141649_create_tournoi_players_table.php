<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournoiPlayersTable extends Migration
{
    public function up()
    {
        Schema::create('tournoi_players', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('tournoi_id')->constrained('tournois')->onDelete('cascade'); 
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');  
            $table->timestamps();  
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournoi_players');
    }
}
