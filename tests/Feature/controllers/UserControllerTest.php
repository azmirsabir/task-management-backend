<?php

namespace Tests\Feature\controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
  protected function authenticateUser()
  {
    Sanctum::actingAs(User::factory()->create());
  }
  
  public function test_save_user()
  {
    $this->authenticateUser();
    
    $userData = [
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => Hash::make('password123'),
    ];
    
    $response = $this->postJson('/api/users', $userData);
    $response->assertStatus(201)
      ->assertJson([
        'status' => 201,
        'message' => 'success'
      ]);
  }
  
  public function test_update_user()
  {
    $this->authenticateUser();
    
    $user = User::factory()->create();
    
    $updatedData = [
      'name' => 'Updated User',
    ];
    
    $response = $this->putJson('/api/users/'.$user->id, $updatedData);
    $response->assertStatus(200)
      ->assertJson([
        'status' => 200,
        'message' => 'success',
      ]);
  }
}
