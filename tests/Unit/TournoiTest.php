<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Tournoi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TournoiTest extends TestCase
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

    public function test_add_tournoi()
    {
        $token = $this->createUserAndGetToken();

        $data = [
            'name' => 'Football Tournament', 
            'rules' => 'Best of 3',          
            'nb_players' => 4,               
            'image' => null,                  
        ];
        

        $response = $this->json('POST', '/api/tournaments', $data, [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Tournoi Added successfully',
                 ]);

        $this->assertDatabaseHas('tournois', [
            'name' => 'Football Tournament',
            'rules' => 'Best of 3',
            'nb_players' => 4,
        ]);
    }

  

    public function test_update_tournoi()
    {
        $token = $this->createUserAndGetToken();
    
        $tournoi = Tournoi::factory()->create([
            'creator_id' => User::first()->id,  
        ]);
    
        $data = [
            'name' => 'Updated Football Tournament',
            'rules' => 'Best of 5',
            'nb_players' => 6,
            'image' => null,
        ];
    
        $response = $this->json('PUT', "/api/tournaments/{$tournoi->id}", $data, [
            'Authorization' => "Bearer $token"
        ]);
    
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Tournoi updated successfully',
                 ]);
    
        $this->assertDatabaseHas('tournois', [
            'id' => $tournoi->id,
            'name' => 'Updated Football Tournament',
            'rules' => 'Best of 5',
            'nb_players' => 6,
        ]);
    }
    
    public function test_delete_tournoi()
    {
        $token = $this->createUserAndGetToken();
    
        $tournoi = Tournoi::factory()->create([
            'creator_id' => User::first()->id,  
        ]);
    
        $response = $this->json('DELETE', "/api/tournaments/{$tournoi->id}", [], [
            'Authorization' => "Bearer $token"
        ]);
    
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'tournoi deleted successfully',  
                 ]);
    
        $this->assertDatabaseMissing('tournois', [
            'id' => $tournoi->id,
        ]);
    }
    


}