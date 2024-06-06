<?php

namespace Tests\Feature\controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
  const NAME = 'azmir';
  const EMAIL = 'azmir@gmail.com';
  const PASSWORD = '1234567';
  
  protected function setUp(): void
  {
    parent::setUp();
    $this->withoutMiddleware(); // Disable middleware like rate limiting for testing
  }
  
  public function test_login_successfully()
  {
    User::factory()->create([
      'email' => self::EMAIL,
      'password' => Hash::make(self::PASSWORD),
    ]);
    
    $this->postJson(route('auth.login'), [
      'email' => self::EMAIL,
      'password' => self::PASSWORD,
    ])
      ->assertOk()
      ->assertJsonStructure([
        'data' => [
          'user' => ['id', 'name', 'email', 'email_verified_at'],
          'token',
        ],
      ]);
  }
  
  public function test_login_unauthorized_when_username_or_password_incorrect()
  {
    User::factory()->create([
      'email' => self::EMAIL,
      'password' => Hash::make(self::PASSWORD),
    ]);
    
    $this->postJson(route('auth.login'), [
      'email' => self::EMAIL,
      'password' => 'a-wrong-password',
    ])
      ->assertUnauthorized()
      ->assertJsonStructure(['message']);
  }
  
  public function test_logout_successfully()
  {
    $user = User::factory()->create();
    $token = $user->createToken('testToken')->plainTextToken;
    
    $this->actingAs($user)
      ->postJson(route('auth.logout'))
      ->assertNoContent();
    
    $this->assertNull($user->fresh()->currentAccessToken());
  }
}