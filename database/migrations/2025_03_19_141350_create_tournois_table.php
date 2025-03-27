<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournoisTable extends Migration
{
    public function up()
    {
        Schema::create('tournois', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('match_date')->nullable(); 
            $table->text('name')->nullable();  
            $table->text('rules')->nullable();  
            $table->integer('nb_players')->default(0);  
            $table->string('image')->nullable();  
            $table->timestamps();  
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournois');
    }
}
