<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('tournoi_id')->constrained('tournois')->onDelete('cascade'); 
            $table->foreignId('player_1_id')->constrained('users')->onDelete('cascade');  
            $table->foreignId('player_2_id')->constrained('users')->onDelete('cascade');  
            $table->integer('score_player_1')->nullable(); 
            $table->integer('score_player_2')->nullable();  
            $table->timestamp('match_date')->nullable();  
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
