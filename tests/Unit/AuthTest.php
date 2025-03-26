<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase; 

    public function test_register()
    { 
        $response = $this->postJson('/api/register', [
            'name' => 'Bouchta',
            'email' => 'Bouchta@example.com',
            'password' => '12301230',
            'password_confirmation' => '12301230',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['token', 'user']);

        $this->assertDatabaseHas('users', [
            'email' => 'Bouchta@example.com',
        ]);
    }

    public function test_login()
    {
        $user = User::factory()->create([
            'name' => 'Bouchta',
            'email' => 'Bouchta@example.com',
            'password' => Hash::make('12301230'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'Bouchta@example.com',
            'password' => '12301230',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    public function test_logout()
    {
        $user = User::factory()->create([
            'name' => 'Bouchta',
            'email' => 'Bouchta@example.com',
            'password' => Hash::make('12301230'),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Successfully logged out']);
    }

    public function test_user()
    {
        $user = User::factory()->create([
            'name' => 'Bouchta',
            'email' => 'Bouchta@example.com',
            'password' => Hash::make('12301230'),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->getJson('/api/user', [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'user' => [
                         'email' => 'Bouchta@example.com'
                     ]
                 ]);
    }
}
