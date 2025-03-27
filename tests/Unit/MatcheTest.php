<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Matche;
use App\Models\Tournoi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class MatcheTest extends TestCase
{
    use RefreshDatabase;

    protected function createUserAndGetToken()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        return JWTAuth::fromUser($user);
    }

    public function test_add_match()
    {
        $token = $this->createUserAndGetToken();

        $tournoi = Tournoi::factory()->create();

        $data = [
            'tournoi_id' => $tournoi->id,        
            'player_1_id' => User::factory()->create()->id,  
            'player_2_id' => User::factory()->create()->id,
            'score_player_1' => 3,  
            'score_player_2' => 2, 
            'match_date' => now(),  
        ];

        $response = $this->json('POST', '/api/matches', $data, [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Match ajouté avec succès',  
                 ]);

        $this->assertDatabaseHas('matches', [
            'tournoi_id' => $tournoi->id,
            'score_player_1' => 3,
            'score_player_2' => 2,
        ]);
    }


    public function test_update_matche()
{
    $token = $this->createUserAndGetToken();

    $matche = Matche::factory()->create();

    $updatedData = [
        'tournoi_id' => $matche->tournoi_id, 
        'score_player_1' => 5,
        'score_player_2' => 3,
    ];

    $response = $this->json('PUT', "/api/matches/{$matche->id}", $updatedData, [
        'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'matche updated successfully',
             ]);

    $this->assertDatabaseHas('matches', array_merge(['id' => $matche->id], $updatedData));
}



    public function test_delete_tournoi()
    {
        $token = $this->createUserAndGetToken();
    
        $matche = Matche::factory()->create();
    
        $response = $this->json('DELETE', "/api/matches/{$matche->id}", [], [
            'Authorization' => "Bearer $token"
        ]);
    
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Matche removed successfully',  
                 ]);
    
        $this->assertDatabaseMissing('matches', [
            'id' => $matche->id,
        ]);
    }
    
    

}
